import {useEffect, useMemo, useState} from 'react';
import {Col, Menu, Row, Statistic} from 'antd';
import apiRegistrations from '../lib/api/apiRegistrations';
import {Link, Route, Switch, useLocation, useRouteMatch} from 'react-router-dom';
import SchoolList from '../components/registration/SchoolList';

const RegistrationPage = () => {
	const {path, url} = useRouteMatch();
	const {pathname} = useLocation();
	const [registrations, setRegistrations] = useState([]);

	const schools = useMemo(() => groupBySchool(registrations), [registrations]);
	const schoolsLinks = Object.fromEntries(Object.keys(schools).map((school) => [school, `${url}/${school}`]));

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

	function handleChange(registration) {
		setRegistrations(st => {
			const i = st.findIndex(({id}) => id === registration.id);
			st[i] = registration;
			return st.slice();
		});
	}

	return (
		<div className="">
			{/*
				--- Menu
			*/}
			<div className="flex justify-between items-center bg-white pr-4">
				<Menu className="flex-auto" mode="horizontal" selectedKeys={[pathname]}>
					{/* Index */}
					<Menu.Item key={url}><Link to={path}>Overview</Link></Menu.Item>
					{/* Schools */}
					{Object.entries(schoolsLinks).map(([school, link]) => (
						<Menu.Item key={link}><Link to={link}>{school}</Link></Menu.Item>))}
				</Menu>
			</div>
			{/*
				--- Content
			*/}
			<div className="bg-white p-6">
				<Switch>
					{/* Index */}
					<Route exact path={path}>
						<Row gutter={32} className="mb-6">
							<Col flex="auto">
								<Statistic title="All registrations" value={registrations.length}/>
							</Col>
						</Row>
					</Route>
					{/* Schools */}
					{Object.entries(schoolsLinks).map(([school, link]) => (
						<Route exact path={link} key={link}>
							<SchoolList school={school} registrations={schools[school]} onDeleted={handleDeleted} onChange={handleChange}/>
						</Route>
					))}
				</Switch>
			</div>
		</div>
	);
};

RegistrationPage.PATH = "/dashboard/registrations";

function groupBySchool(registrations) {
	return registrations.reduce((acc, registration) => {
		const school = registration.school;

		if (Array.isArray(acc[school])) {
			acc[school].push(registration);
		} else {
			acc[school] = [];
		}

		return acc;
	}, {});
}

export default RegistrationPage;