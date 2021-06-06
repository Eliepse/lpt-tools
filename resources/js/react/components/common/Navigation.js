import {Menu} from 'antd';
import styles from '../../app.module.scss';
import {Link, useRouteMatch} from 'react-router-dom';
import {useAuth} from '../../lib/auth/useAuth';
import {UserOutlined} from '@ant-design/icons';
import {PAGES} from '../../app';

function Navigation() {
	const {user, logout} = useAuth();
	const {path} = useRouteMatch();

	return (
		<div className={styles.navigationContainer}>
			<Menu mode="horizontal" selectedKeys={[path]}>
				{PAGES.map(({path, name}) => (
					<Menu.Item key={path}>
						<Link to={path}>{name}</Link></Menu.Item>
				))}
			</Menu>
			{user && (
				<Menu mode="horizontal">
					<Menu.SubMenu key="user" icon={<UserOutlined/>} title={user.name}>
						<Menu.Item key="user:logout" onClick={logout}>
							Logout
						</Menu.Item>
					</Menu.SubMenu>
				</Menu>
			)}
		</div>
	);
}

export default Navigation;