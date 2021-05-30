import {useEffect, useState} from 'react';
import {Col, Menu, Row, Statistic} from 'antd';
import apiRegistrations from '../lib/api/apiRegistrations';
import {Link, Route, Switch, useRouteMatch} from 'react-router-dom';
import RegistrationCard from '../components/registration/RegistrationCard';

const RegistrationPage = () => {
	const {path, url} = useRouteMatch();
	const [registrations, setRegistrations] = useState([]);

	useEffect(() => {
		apiRegistrations.all()
			.then((data) => {
				if (!data) {
					console.error("Courses data is empty.");
					return;
				}

				setRegistrations(data);
				console.debug(data[0]);
			});
	}, []);

	return (
		<div className="">
			<div className="flex justify-between items-center bg-white pr-4">
				<Menu className="flex-auto" mode="horizontal">
					<Menu.Item key="overview"><Link to={path}>Overview</Link></Menu.Item>
					<Menu.Item key="courses"><Link to={`${url}/courses`}>Courses</Link></Menu.Item>
				</Menu>
			</div>
			<div className="bg-white p-6">
				<Switch>
					<Route exact path={path}>
						<Row gutter={32} className="mb-6">
							<Col flex="auto">
								<Statistic title="Registrations" value={registrations.length}/>
							</Col>
						</Row>
					</Route>
					<Route exact path={`${url}/courses`}>
						<ul className="list-none p-0">
							{registrations.map((registration) => (
								<li className="mb-4">
									<RegistrationCard registration={registration}/>
								</li>
							))}
						</ul>
					</Route>
				</Switch>
			</div>
		</div>
	);
};

RegistrationPage.PATH = "/dashboard/registrations";

export default RegistrationPage;