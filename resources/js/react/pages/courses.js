import {useEffect, useState} from 'react';
import {Col, Divider, Menu, Row, Statistic} from 'antd';
import Course from '../components/courses/Course';
import apiCourse from '../lib/api/apiCourse';
import CreateCourseModal from '../components/courses/CreateCourseModal';

export const PATH = "/dashboard/courses";

export const Page = () => {

	const [currentTab, setCurrentTab] = useState("overview");
	const [courses, setCourses] = useState([]);
	const [schools, setSchools] = useState([]);

	useEffect(() => {
		apiCourse.all()
			.then((data) => {
				if (!data) {
					console.error("Courses data is empty.");
					return;
				}

				setCourses(data);
				setSchools(
					data.reduce((acc, course) => {
						const school = course.school;
						if (!acc.includes(school)) {
							acc.push(school);
						}
						return acc;
					}, []),
				);
			});
	}, []);

	const filteredSchool = currentTab === "overview" ? courses : getCourseBySchool(currentTab);

	function getCourseBySchool(school) {
		return courses.filter((course) => course.school === school);
	}

	function handleCourseCreated(course) {
		setCourses(st => [...st, course]);
		setSchools(st => [...st, course.school]);
		setCurrentTab(course.school);
	}

	function handleCourseDeleted(id) {
		setCourses(st => st.filter((course) => course.id !== id));
	}

	return (
		<div className="">
			<div className="flex justify-between items-center bg-white pr-4">
				<Menu className="flex-auto" mode="horizontal" activeKey={currentTab} onSelect={(e) => setCurrentTab(e.key)}>
					<Menu.Item key="overview">Overview</Menu.Item>
					{schools.map((school) => <Menu.Item key={school} className="capitalize">{school}</Menu.Item>)}
				</Menu>
				<CreateCourseModal defaultSchool="belleville" defaultCategory="chinese" schoolsOptions={schools} onCreated={handleCourseCreated}/>
			</div>
			<div className="bg-white p-6">
				<Row gutter={32} className="mb-6">
					<Col flex="auto">
						<Statistic title="Total class hours" value={_getTotalHours(filteredSchool) + " h"}/>
					</Col>
					<Col flex="auto">
						<Statistic title="Total classes" value={_getTotalClasses(filteredSchool)}/>
					</Col>
				</Row>
				{currentTab !== "overview" && <>
					<Divider/>
					<Row gutter={[16, 16]}>
						{getCourseBySchool(currentTab).map((course) => (
							<Col span={12} key={course.id}>
								<Course
									id={course.id}
									name={course.name}
									category={course.category}
									duration={{value: course.duration, denominator: course.duration_denominator}}
									price={{value: course.price, denominator: course.price_denominator}}
									schedules={course.schedules}
									onDeleted={handleCourseDeleted}
								/>
							</Col>
						))}
					</Row>
				</>}
			</div>
		</div>
	);
};

function _getCourseMinutesCount(course) {
	return Object.values(course.schedules).reduce((acc, hour) => acc + hour.length, 0) * course.duration;
}

function _getTotalHours(courses) {
	return courses.reduce((acc, course) => acc + _getCourseMinutesCount(course), 0) / 60;
}

function _getCourseClassesCount(course) {
	return Object.values(course.schedules).reduce((acc, hour) => acc + hour.length, 0);
}

function _getTotalClasses(courses) {
	return courses.reduce((acc, course) => acc + _getCourseClassesCount(course), 0);
}