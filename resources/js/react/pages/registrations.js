import {useEffect, useMemo, useState} from 'react';
import {Col, Menu, Row, Statistic} from 'antd';
import apiRegistrations from '../lib/api/apiRegistrations';
import {Link, Route, Switch, useRouteMatch} from 'react-router-dom';
import SchoolList from '../components/registration/SchoolList';

const RegistrationPage = () => {
	const {path, url} = useRouteMatch();
	const [registrations, setRegistrations] = useState([]);

	const schools = useMemo(() => {
		return registrations.reduce((acc, registration) => {
			const school = registration.school;

			if (Array.isArray(acc[school])) {
				acc[school].push(registration);
			} else {
				acc[school] = [];
			}

			return acc;
		}, {});
	}, [registrations]);

	useEffect(() => {
		apiRegistrations.all()
			.then((data) => {
				if (!data) {
					console.error("Courses data is empty.");
					return;
				}

				setRegistrations(data);
			});
	}, []);

	function handleDeleted(id) {
		setRegistrations(st => st.filter((registration) => registration.id !== id));
	}

	return (
		<div className="">
			<div className="flex justify-between items-center bg-white pr-4">
				<Menu className="flex-auto" mode="horizontal">
					<Menu.Item key="overview"><Link to={path}>Overview</Link></Menu.Item>
					{Object.keys(schools).map((school) => (
						<Menu.Item key={school}><Link to={`${url}/${school}`}>{school}</Link></Menu.Item>
					))}
				</Menu>
			</div>
			<div className="bg-white p-6">
				<Switch>
					<Route exact path={path}>
						<Row gutter={32} className="mb-6">
							<Col flex="auto">
								<Statistic title="All registrations" value={registrations.length}/>
							</Col>
						</Row>
					</Route>
					{Object.entries(schools).map(([school, registrations]) => (
						<Route exact path={`${url}/${school}`}>
							<SchoolList school={school} registrations={registrations} onDeleted={handleDeleted}/>
						</Route>
					))}
				</Switch>
			</div>
		</div>
	);
};

RegistrationPage.PATH = "/dashboard/registrations";

export default RegistrationPage;