import {BrowserRouter as Router, Route, Switch} from "react-router-dom";

import {Layout} from 'antd';
import * as Courses from "./pages/courses";
import {AuthProvider} from './lib/auth/AuthProvider';
import AuthRequired from './lib/auth/AuthRequired';
import Dashboard from './components/layouts/Dashboard';
import LoginForm from './components/layouts/LoginForm';
import RegistrationPage from './pages/registrations';
import dayjs from 'dayjs';
import RelativeTime from "dayjs/plugin/relativeTime";

export default function App() {
	dayjs.extend(RelativeTime);

	return (
		<AuthProvider>
			<Router>
				<AuthRequired>
					<Switch>
						<Route exact path="/dashboard/login">
							<Layout className="h-screen flex justify-center items-center">
								<LoginForm/>
							</Layout>
						</Route>
						<Route exact path="/dashboard">
							<Dashboard>
								<p>Welcome!</p>
							</Dashboard>
						</Route>
						<Route exact path="/dashboard/courses">
							<Dashboard>
								<Courses.Page/>
							</Dashboard>
						</Route>
						<Route path={RegistrationPage.PATH}>
							<Dashboard>
								<RegistrationPage />
							</Dashboard>
						</Route>
					</Switch>
				</AuthRequired>
			</Router>
		</AuthProvider>
	);
}