import {BrowserRouter as Router, Route, Switch} from "react-router-dom";
import {AuthProvider} from './lib/auth/AuthProvider';
import AuthRequired from './lib/auth/AuthRequired';
import Dashboard from './components/layouts/Dashboard';
import LoginForm from './components/layouts/LoginForm';
import dayjs from 'dayjs';
import RelativeTime from "dayjs/plugin/relativeTime";
import loadable from "@loadable/component";
import Loading from './components/layouts/Loading';

export const PAGES = [
	{
		path: "/dashboard",
		page: "dashboard",
		name: "Home",
		exact: true,
	},
	{
		path: "/dashboard/registrations",
		page: "registrations",
		name: "Registrations",
		exact: false,
	},
	{
		path: "/dashboard/courses",
		page: "courses",
		name: "Courses",
		exact: true,
	},
];

export default function App() {
	dayjs.extend(RelativeTime);

	return (
		<AuthProvider>
			<Router>
				<AuthRequired>
					<Switch>
						<Route exact path="/dashboard/login">
							<div className="min-h-screen pt-12 bg-gray-100 flex flex-col justify-center items-center">
								<LoginForm/>
							</div>
						</Route>
						{PAGES.map(({path, page, exact}) => (
							<Route exact={exact} path={path} key={path}>
								<Dashboard>
									<LoadablePage id={path} page={page}/>
								</Dashboard>
							</Route>
						))}
					</Switch>
				</AuthRequired>
			</Router>
		</AuthProvider>
	);
}

const LoadablePage = loadable(({page}) => import(`./pages/${page}`), {
	fallback: <Loading/>,
	cacheKey: ({page}) => page,
});