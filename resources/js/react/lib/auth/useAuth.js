import {useContext} from 'react';
import {authContext} from './AuthProvider';

export function useAuth() {
	const auth = useContext(authContext);

	function isAuth() {
		return Boolean(auth?.user);
	}

	function isInitialized() {
		return !auth.initializing;
	}

	return {
		...auth,
		isInitialized,
		isAuth,
	};
}