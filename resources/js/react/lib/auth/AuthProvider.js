import {createContext, useEffect, useMemo, useState} from 'react';
import {getCsrfToken} from '../api/fetchers';

export const authContext = createContext({
	user: null,
	apiToken: null,
	login: () => {},
	logout: () => {},
});

export function AuthProvider({children}) {
	const [user, setUser] = useState(null);
	const [token, setToken] = useState(getCsrfToken());
	const [initializing, setInitializing] = useState(true);

	// Check if the user is already authenticated
	useEffect(() => {
		if (!token) {
			console.info("[Auth] Token missing");
			authInitialized();
			return;
		}

		function authInitialized() {
			setTimeout(() => {
				setInitializing(false);
			}, 500);
		}

		checkAuth(token)
			.then((data) => {
				console.info("[Auth] Already authenticated");
				authInitialized();
				setUser(data);
			})
			.catch(() => {
				console.info("[Auth] Not authenticated");
				authInitialized();
			});
	}, []);


	function login(email, password) {
		if (user) {
			return;
		}

		requestCsrfToken()
			.then((token) => {
				setToken(token);
				requestLogin(email, password)
					.then((data) => {
						console.info("[Auth] Authenticated");
						setUser(data);
					})
					.catch(console.error);
			})
			.catch(console.error);
	}

	function logout() {
		fetch("/api/logout", {
			method: "POST",
			headers: {
				"X-XSRF-TOKEN": getCsrfToken(),
				"Accept": "application/json",
			},
		})
			.then((response) => {
				if (!response.ok) {
					console.error(response);
					return;
				}

				setUser(null);
			})
			.catch(console.error);
	}

	const auth = useMemo(() => ({
		user,
		initializing,
		login,
		logout,
	}), [user, initializing]);

	return <authContext.Provider value={auth} children={children}/>;
}

function requestCsrfToken() {
	console.info("[Auth] Requesting token");
	return new Promise((resolve, reject) => {
		fetch("/sanctum/csrf-cookie", {
			headers: {
				"Accept": "application/json",
			},
		}).then(
			(response) => {
				if (response.ok) {
					const cookies = Object.fromEntries(
						document.cookie.split(";").map((val) => val.split("=")),
					);
					resolve(decodeURIComponent(cookies["XSRF-TOKEN"]));
				}

				reject(response);
			}).catch(reject);
	});
}

function checkAuth(token) {
	console.info("[Auth] Checking auth");
	return getUser(token);
}

function getUser() {
	return new Promise((resolve, reject) => {
		fetch("/api/me", {
			method: "GET",
			headers: {
				"X-XSRF-TOKEN": getCsrfToken(),
				"Accept": "application/json",
			},
		})
			.then((response) => {
				if (!response.ok) {
					reject(response);
					return;
				}

				if (response.status === 204) {
					resolve();
					return;
				}

				response.json().then(resolve).catch(reject);
			})
			.catch(reject);
	});
}

function requestLogin(email, password) {
	return new Promise((resolve, reject) => {
		fetch("/api/login", {
			method: "POST",
			headers: {
				"X-XSRF-TOKEN": getCsrfToken(),
				"Accept": "application/json",
				"Content-Type": "application/json",
			},
			body: JSON.stringify({email, password}),
		})
			.then((response) => {
				if (!response.ok) {
					reject(response);
					return;
				}

				response.json().then(resolve).catch(reject);
			})
			.catch(reject);
	});
}