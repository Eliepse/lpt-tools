import {Col, Row, Statistic} from 'antd';
import RegistrationCard from './RegistrationCard';

const SchoolList = ({school, registrations, onDeleted, onChange}) => {
	return (
		<>
			<Row gutter={32} className="mb-6">
				<Col flex="auto">
					<Statistic title="Registrations" value={registrations.length}/>
				</Col>
			</Row>
			<ul className="list-none p-0">
				{registrations.map((registration) => (
					<li className="mb-4" key={registration.id}>
						<RegistrationCard registration={registration} onDeleted={onDeleted} onChange={onChange}/>
					</li>
				))}
			</ul>
		</>
	);
};

export default SchoolList;