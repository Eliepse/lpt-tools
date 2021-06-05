import {Badge, Col, Row, Statistic} from 'antd';
import RegistrationCard from './RegistrationCard';
import Title from 'antd/es/typography/Title';
import {useMemo} from 'react';

const SchoolList = ({registrations, onDeleted, onChange}) => {
	const [reviewed, pendingReview] = useMemo(() => {
		return registrations.reduce((acc, r) => {
			const i = r.reviewed_at ? 0 : 1;
			acc[i].push(r);
			return acc;
		}, [[], []]);
	}, [registrations]);

	return (
		<>
			<Row gutter={32} className="mb-6">
				<Col flex="auto">
					<Statistic title="Registrations" value={registrations.length}/>
				</Col>
				<Col flex="auto">
					<Statistic title="To review" value={pendingReview.length}/>
				</Col>
			</Row>
			{pendingReview.length > 0 && (
				<>
					<Title level={2}>To review <Badge count={pendingReview.length}/></Title>
					<ul className="list-none p-0">
						{pendingReview.map((registration) => (
							<li className="mb-4" key={registration.id}>
								<RegistrationCard registration={registration} onDeleted={onDeleted} onChange={onChange}/>
							</li>
						))}
					</ul>
					<Title level={2}>Reviewed</Title>
				</>
			)}
			<ul className="list-none p-0">
				{reviewed.map((registration) => (
					<li className="mb-4" key={registration.id}>
						<RegistrationCard registration={registration} onDeleted={onDeleted} onChange={onChange}/>
					</li>
				))}
			</ul>
		</>
	);
};

export default SchoolList;