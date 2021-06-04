import {Menu} from 'antd';
import styles from '../../app.module.scss';
import {Link} from 'react-router-dom';
import * as Courses from '../../pages/courses';
import {useAuth} from '../../lib/auth/useAuth';
import {UserOutlined} from '@ant-design/icons';
import RegistrationPage from '../../pages/registrations';

function Navigation() {
	const {user, logout} = useAuth();

	return (
		<div className={styles.navigationContainer}>
			<Menu mode="horizontal">
				<Menu.Item key="home"><Link to="/dashboard">Home</Link></Menu.Item>
				<Menu.Item key="registrations"><Link to={RegistrationPage.PATH}>Registrations</Link></Menu.Item>
				<Menu.Item key="courses"><Link to={Courses.PATH}>Courses</Link></Menu.Item>
			</Menu>
			{user && (
				<Menu mode="horizontal">
					<Menu.SubMenu key="user" icon={<UserOutlined />} title={user.name}>
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