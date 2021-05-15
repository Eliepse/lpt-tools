import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";

import {Breadcrumb, Layout, Menu} from 'antd';
import styles from "./app.module.scss";
import * as Courses from "./pages/courses";
import {AuthProvider} from './lib/auth/AuthProvider';
import AuthRequired from './lib/auth/AuthRequired';
import Navigation from './components/common/Navigation';

const {Header, Content, Footer} = Layout;

export default function App() {
	return (
		<AuthProvider>
			<Router>
				<AuthRequired>
					<Layout className={styles.layout}>
						<Header className={styles.header}>
							<Navigation />
						</Header>
						<Content className={styles.content} style={{padding: '0 50px'}}>
							<Breadcrumb style={{margin: '16px 0'}}>
								<Breadcrumb.Item>Home</Breadcrumb.Item>
							</Breadcrumb>
							<div className={styles.siteLayoutContent}>
								<Switch>
									<Route exact path="/dashboard/courses" children={<Courses.Page/>}/>
								</Switch>
							</div>
						</Content>
						<Footer style={{textAlign: 'center'}}>Les Petits Trilingues - Created by Eliepse</Footer>
					</Layout>
				</AuthRequired>
			</Router>
		</AuthProvider>
	);
}