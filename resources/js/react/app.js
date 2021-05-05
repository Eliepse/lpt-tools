import {BrowserRouter as Router, Switch, Route, Link} from "react-router-dom";

import {Breadcrumb, Button, Layout, Menu} from 'antd';

const {Header, Content, Footer} = Layout;
import styles from "./app.module.scss";

export default function App() {
	return (
		<Router>
			<Layout className={styles.layout}>
				<Header className={styles.header}>
					<Menu mode="horizontal" className={styles.menu}>
						<Menu.Item key="home">Home</Menu.Item>
						<Menu.Item key="registrations">Inscription</Menu.Item>
					</Menu>
				</Header>
				<Content className={styles.content} style={{padding: '0 50px'}}>
					<Breadcrumb style={{margin: '16px 0'}}>
						<Breadcrumb.Item>Home</Breadcrumb.Item>
					</Breadcrumb>
					<div className={styles.siteLayoutContent}>

					</div>
				</Content>
				<Footer style={{textAlign: 'center'}}>Les Petits Trilingues - Created by Eliepse</Footer>
			</Layout>
		</Router>
	);
}