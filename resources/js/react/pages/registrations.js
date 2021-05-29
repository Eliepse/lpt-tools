import {useEffect, useState} from 'react';
import {Card, Col, Divider, Menu, Row, Statistic, Typography} from 'antd';
import apiRegistrations from '../lib/api/apiRegistrations';
import {Link, Route, Switch, useRouteMatch} from 'react-router-dom';
import dayjs from 'dayjs';

const {Text} = Typography;

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
								<li className="mb-6">
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

function RegistrationCard({registration}) {
	const {student, contact, school, category, schedule, course} = registration;
	return (
		<Card
			size="small"
			title={
				<>
					<p className="font-bold mb-1">{`${student.firstname} ${student.lastname}`}</p>
					<div className="flex justify-between items-center">
						<span className="text-gray-400 text-sm">{dayjs(registration.created_at).format("YYYY-MM-DD")}</span>
						<span className="text-gray-400 text-xs uppercase">ID: {registration.uid}</span>
					</div>
				</>
			}
		>
			<Text>
				{student.fullname_cn}<br/>
				{student.birthday}<br/>
				{student.city_code}
			</Text>
			<Divider orientation="left" plain>Contacts</Divider>
			<Text>
				{contact.phone_1}<br/>
				{contact.phone_2}<br/>
				@{contact.wechat_1}
			</Text>
			<Divider orientation="left" plain>Course</Divider>
			<Text>
				[{category}] {course.name}<br/>
				School: {school}<br/>
				Price: {course.price} / {course.price_denominator}<br/>
				Duration: {course.duration} / {course.duration_denominator}<br/>
				Schedule: {schedule.days} {schedule.hour}
			</Text>
		</Card>
	);
}

export default RegistrationPage;