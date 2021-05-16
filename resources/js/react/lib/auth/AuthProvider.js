import {createContext, useEffect, useMemo, useState} from 'react';
import Api, {getCsrfToken} from '../api/broker';
import {Layout, Spin} from 'antd';

export const authContext = createContext({
	user: null,
	apiToken: null,
	login: () => {},
	logout: () => {},
});

export function AuthProvider({children}) {
	const [user, setUser] = useState(null);
	const [initializing, setInitializing] = useState(true);

	// Check if the user is already authenticated
	useEffect(() => {
		function authInitialized() {
			setTimeout(() => setInitializing(false), 250);
		}

		// Break if there is no token
		if (!getCsrfToken()) {
			console.info("[Auth] Token missing");
			authInitialized();
			return;
		}

		// If there is a token, we check if the user is connected
		console.info("[Auth] Checking auth");
		Api.get("/me")
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


	function login(email, password, remember) {
		if (user) {
			return;
		}

		Api.requestToken()
			.then(() => {

				Api.post("/login", {email, password, remember})
					.then((data) => {
						console.info("[Auth] Authenticated");
						setUser(data);
					})
					.catch(console.error);

			})
			.catch(console.error);
	}

	function logout() {
		Api.post("/logout")
			.then(() => setUser(null))
			.catch(console.error);
	}

	const auth = useMemo(() => ({
		user,
		initializing,
		login,
		logout,
	}), [user, initializing]);

	// Display a loader until the Auth provider is ready
	if (initializing) {
		return (
			<Layout className="h-screen flex justify-center items-center">
				<Spin size="large"/>
			</Layout>
		);
	}

	return <authContext.Provider value={auth} children={children}/>;
}