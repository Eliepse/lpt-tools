import styles from '../../app.module.scss';
import Navigation from '../common/Navigation';
import {Breadcrumb, Layout} from 'antd';
import PropTypes from 'prop-types';

const {Header, Content, Footer} = Layout;

function Dashboard({children}) {
	return (
		<Layout className={styles.layout}>
			<Header className={styles.header}>
				<Navigation/>
			</Header>
			<Content className={styles.content} style={{padding: '0 50px'}}>
				<Breadcrumb style={{margin: '16px 0'}}>
					<Breadcrumb.Item>Home</Breadcrumb.Item>
				</Breadcrumb>
				<div className={styles.siteLayoutContent}>
					{children}
				</div>
			</Content>
			<Footer style={{textAlign: 'center'}}>Les Petits Trilingues - Created by Eliepse</Footer>
		</Layout>
	);
}

Dashboard.propTypes = {
	children: PropTypes.element.isRequired,
};

export default Dashboard;