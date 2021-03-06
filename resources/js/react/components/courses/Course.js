import PropTypes from 'prop-types';
import {Card, Divider, Input, Popconfirm, Select} from 'antd';
import {useEffect, useState} from 'react';
import {CheckOutlined, CloseOutlined, DeleteOutlined, EditOutlined} from '@ant-design/icons';
import ScheduleList from './ScheduleList';
import apiCourse from '../../lib/api/apiCourse';
import Price from './Price';
import Duration from './Duration';

const Course = ({id = null, name, category, duration, price, schedules = {}, onDeleted}) => {

	const [edit, setEdit] = useState(false);
	const [course, setCourse] = useState(() => ({id, name, category, duration, price, schedules}));
	const [loading, setLoading] = useState(false);

	// Reset the override when original values changes
	useEffect(() => {
		if (edit) {
			return;
		}

		setCourse({id, name, category, duration, price, schedules});
	}, [id, name, category, duration, price, schedules, edit]);

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
			apiCourse.update({id: course.id, ...data}).then(onSuccess).catch(onFailure);
		} else {
			apiCourse.create(data).then(onSuccess).catch(onFailure);
		}
	}

	function deleteCourse() {
		apiCourse.remove({id})
			.then(() => {
				if (typeof onDeleted === "function") {
					onDeleted(id);
				}
			})
			.catch(console.error);
	}

	const editBtn = <span onClick={() => setEdit(true)}><EditOutlined/> Edit</span>;
	const cancelEditBtn = <span onClick={() => setEdit(false)}><CloseOutlined/> Cancel</span>;
	const saveBtn = <span onClick={saveCourse} className="text-green-500"><CheckOutlined/> Save</span>;
	const deleteBtn = (
		<Popconfirm
			title="Are you sure to delete this course?"
			onConfirm={deleteCourse}
			okText="Delete"
			cancelText="Keep"
		>
			<span className=""><DeleteOutlined/> Delete</span>
		</Popconfirm>
	);

	return (
		<Card
			loading={loading}
			className="mb-6"
			title={<Header name={course.name} category={course.category} edit={edit} onChange={handleHeaderChange}/>}
			actions={edit ? [deleteBtn, saveBtn, cancelEditBtn] : [editBtn]}
		>
			<Duration
				value={course.duration.value}
				denominator={course.duration.denominator}
				edit={edit}
				onChange={(el) => setCourse(st => ({...st, duration: el}))}
			/>
			<Price
				value={course.price.value}
				denominator={course.price.denominator}
				edit={edit}
				onChange={(el) => setCourse(st => ({...st, price: el}))}
			/>
			<Divider/>
			<ScheduleList schedules={course.schedules} edit={edit} onChange={handleScheduleListUpdate}/>
		</Card>
	);
};

Course.propTypes = {
	id: PropTypes.number,
	name: PropTypes.string,
	category: PropTypes.string.isRequired,
	duration: PropTypes.exact({value: PropTypes.number.isRequired, denominator: PropTypes.string.isRequired}),
	price: PropTypes.exact({value: PropTypes.number.isRequired, denominator: PropTypes.string.isRequired}),
	schedules: PropTypes.object,
	onDeleted: PropTypes.func,
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