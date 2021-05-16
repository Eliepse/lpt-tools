import {useAuth} from './useAuth';
import {useRouter} from '../useRouter';
import {useEffect} from 'react';

export default function AuthRequired({children}) {
	const auth = useAuth();
	const router = useRouter();

	// Redirect the client when no more authenticated
	useEffect(() => {
		if (!auth.isInitialized()) {
			return;
		}

		if (!auth.isAuth() && router.pathname !== "/dashboard/login") {
			router.push("/dashboard/login");
		}

		if (auth.isAuth() && router.pathname === "/dashboard/login") {
			router.push("/dashboard");
		}
	}, [auth.isInitialized(), auth.isAuth(), router.pathname]);

	return children;
}