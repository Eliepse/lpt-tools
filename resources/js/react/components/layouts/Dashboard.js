import styles from '../../app.module.scss';
import Navigation from '../common/Navigation';
import PropTypes from 'prop-types';

function Dashboard({children}) {
	return (
		<div className={styles.layout}>
			<header className={styles.header}>
				<Navigation/>
			</header>
			<div className={styles.content}>
				{children}
			</div>
			<footer className={styles.footer}>Les Petits Trilingues - Created by Eliepse</footer>
		</div>
	);
}

Dashboard.propTypes = {
	children: PropTypes.element.isRequired,
};

export default Dashboard;