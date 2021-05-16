import PropTypes from 'prop-types';
import {Card, Divider, Input, Select} from 'antd';
import {useEffect, useState} from 'react';
import {CheckOutlined, CloseOutlined, EditOutlined} from '@ant-design/icons';
import Fraction from './Fraction';
import ScheduleList from './ScheduleList';
import apiCourse from '../../lib/api/apiCourse';

const Course = ({id = null, name, category, duration, price, schedules = {}}) => {

	const [edit, setEdit] = useState(false);
	const [course, setCourse] = useState(() => ({name, category, duration, price, schedules}));
	const [loading, setLoading] = useState(false);

	// Reset the override when original values changes
	useEffect(() => {
		if (edit) {
			return;
		}

		setCourse({name, category, duration, price, schedules});
	}, [name, category, duration, price, schedules, edit]);

	function handleScheduleListUpdate(schedules) {
		setCourse(st => ({...st, schedules}));
	}

	function handleHeaderChange(name, category) {
		setCourse(st => ({...st, name, category}));
	}

	function saveCourse() {
		if (!edit) {
			return;
		}

		setEdit(false);
		setLoading(true);

		const data = {
			name: course.name,
			category: course.category,
			duration: course.duration.value,
			duration_denominator: course.duration.denominator,
			price: course.price.value,
			price_denominator: course.price.denominator,
			schedules: course.schedules,
		};

		function onSuccess(data) {
			setCourse({
				id: data.id,
				name: data.name,
				category: data.category,
				duration: {value: data.duration, denominator: data.duration_denominator},
				price: {value: data.price, denominator: data.price_denominator},
				schedules: data.schedules,
			});
			setLoading(false);
		}

		function onFailure(err) {
			console.error(err);
			setLoading(false);
		}

		if (id) {
			apiCourse.update({id, ...data}).then(onSuccess).catch(onFailure);
		}
	}

	const editCourseBtn = <span onClick={() => setEdit(true)} key="a"><EditOutlined/> Edit</span>;
	const cancelEditBtn = <span onClick={() => setEdit(false)} key="b"><CloseOutlined/> Cancel</span>;
	const saveCourseBtn = <span onClick={saveCourse} className="text-green-500" key="c"><CheckOutlined/> Save</span>;

	return (
		<Card
			loading={loading}
			className="mb-6"
			title={<Header name={course.name} category={course.category} edit={edit} onChange={handleHeaderChange}/>}
			actions={edit ? [saveCourseBtn, cancelEditBtn] : [editCourseBtn]}
		>
			<Fraction
				value={course.duration.value}
				denominator={course.duration.denominator}
				unit="min"
				options={["year", "month", "week", "day"]}
				onChange={(el) => setCourse(st => ({...st, duration: el}))}
				edit={edit}
			/>
			<Fraction
				value={course.price.value}
				denominator={course.price.denominator}
				unit="€"
				options={["year", "month", "week", "day"]}
				onChange={(el) => setCourse(st => ({...st, price: el}))}
				edit={edit}
			/>
			<Divider/>
			<ScheduleList schedules={course.schedules} edit={edit} onChange={handleScheduleListUpdate}/>
		</Card>
	);
};

Course.propTypes = {
	id: PropTypes.number,
	name: PropTypes.string.isRequired,
	category: PropTypes.string.isRequired,
	duration: PropTypes.exact({value: PropTypes.number.isRequired, denominator: PropTypes.string.isRequired}),
	price: PropTypes.exact({value: PropTypes.number.isRequired, denominator: PropTypes.string.isRequired}),
	schedules: PropTypes.object,
};

function Header({name, category, edit = false, onChange}) {

	if (edit) {
		return (
			<div className="flex">
				<Input
					type="text"
					className="mr-2"
					value={name}
					onChange={(e) => onChange(e.target.value, category)}
				/>
				<Select
					type="text"
					value={category}
					onChange={(e) => onChange(name, e)}
				>
					<Select.Option value="chinese">chinese</Select.Option>
					<Select.Option value="english">english</Select.Option>
					<Select.Option value="maths">maths</Select.Option>
					<Select.Option value="art">art</Select.Option>
					<Select.Option value="french">french</Select.Option>
					<Select.Option value="vacation">vacation</Select.Option>
					<Select.Option value="support">support</Select.Option>
				</Select>
			</div>
		);
	}

	return (
		<div className="flex items-center justify-between">
			<h3 className="">{name}</h3>
			<p className="uppercase text-gray-400 text-sm mb-0">{category}</p>
		</div>
	);

}

export default Course;