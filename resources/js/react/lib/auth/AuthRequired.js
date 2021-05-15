import {useAuth} from './useAuth';
import {Layout, Spin} from 'antd';
import {useRouter} from '../useRouter';
import {useEffect} from 'react';
import LoginForm from '../../components/LoginForm';

export default function AuthRequired({children}) {
	const auth = useAuth();
	const router = useRouter();

	// Redirect the client when no more authenticated
	useEffect(() => {
		if (!auth.isAuth()) {
			router.push("/dashboard");
		}
	}, [auth.isAuth()]);

	// Display a loader until the Auth provider is ready
	if (!auth.isInitialized()) {
		return (
			<Layout className="h-screen flex justify-center items-center">
				<Spin size="large"/>
			</Layout>
		);
	}

	// If not authenticated, we display the login interface
	if (!auth.isAuth()) {
		return (
			<Layout className="h-screen flex justify-center items-center">
				<LoginForm/>
			</Layout>
		);
	}

	return children;
}