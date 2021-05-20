import {useEffect, useState} from 'react';
import {AutoComplete, Button, Divider, Form, Input, Modal, Select} from 'antd';
import PropTypes from 'prop-types';
import {PlusOutlined} from '@ant-design/icons';
import Duration from './Duration';
import Price from './Price';
import apiCourse from '../../lib/api/apiCourse';

const spacesToDashRegex = new RegExp(/(\s|-)+/gi);
const restrictiveCharsRegex = new RegExp(/[^A-Za-z0-9-]/gi);

function CreateCourseModal({defaultSchool = null, defaultCategory = null, schoolsOptions = [], onCreated}) {
	const [visible, setVisible] = useState(false);
	const [loading, setLoading] = useState(false);
	const [course, setCourse] = useState({
		price: {value: 400, denominator: "year"},
		duration: {value: 120, denominator: "week"},
		school: defaultSchool,
		category: defaultCategory,
	});

	useEffect(() => {
		if (!visible) {
			setLoading(false);
			setCourse(st => ({
				...st,
				name: "",
			}));
		}
	}, [visible]);

	function showModal() {
		setVisible(true);
	}

	function handleSubmit() {
		setLoading(true);
		apiCourse.create({
			...course,
			duration: course.duration.value,
			duration_denominator: course.duration.denominator,
			price: course.price.value,
			price_denominator: course.price.denominator,
		})
			.then((data) => {
				onCreated(data);
				setVisible(false);
			})
			.catch((err) => {
				console.error(err);
			})
			.finally(() => {
				setLoading(false);
			});
	}

	function handleCancel() {
		setVisible(false);
	}

	function handleSchoolChange(value) {
		setCourse(st => {
			console.debug(value);
			let school = value
				.toLowerCase()
				.replaceAll(spacesToDashRegex, "-")
				.replaceAll(restrictiveCharsRegex, "");
			return {...st, school};
		});
	}

	function getSchoolOptions() {
		const options = schoolsOptions.map(s => ({value: s}));

		if (course.school.length === 0 || schoolsOptions.includes(course.school)) {
			return options;
		}

		return [{value: course.school}, ...options];
	}

	return (
		<>
			<Button type="primary" onClick={showModal}><PlusOutlined/> New course</Button>
			<Modal
				title="Title"
				visible={visible}
				onOk={handleSubmit}
				confirmLoading={loading}
				onCancel={handleCancel}
			>
				<Form.Item label="Name & category" className="block">
					<div className="flex">
						<Input
							type="text"
							className="flex-1 mr-2"
							value={course.name}
							placeholder="Course name"
							onChange={(e) => setCourse(st => ({...st, name: e.target.value}))}
						/>
						<Select
							type="text"
							style={{maxWidth: "8rem"}}
							value={course.category}
							onChange={(value) => setCourse(st => ({...st, category: value}))}
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
				</Form.Item>
				<Form.Item label="School ID" className="block">
					<AutoComplete
						className="block"
						placeholder="School ID (existing or new)"
						options={getSchoolOptions()}
						value={course.school}
						onChange={handleSchoolChange}
					/>
					<p className="text-gray-500 mt-2 mb-0">
						You can use an existing school ID, or create a new one.
						The real (full) name of the school is handle somewhere else.
					</p>
				</Form.Item>
				<Divider/>
				<Form.Item label="Duration" className="block">
					<Duration
						value={course.duration.value}
						denominator={course.duration.denominator}
						edit
						onChange={(el) => setCourse(st => ({...st, duration: el}))}
					/>
				</Form.Item>
				<Form.Item label="Price" className="block">
					<Price
						value={course.price.value}
						denominator={course.price.denominator}
						edit
						onChange={(el) => setCourse(st => ({...st, price: el}))}
					/>
				</Form.Item>
			</Modal>
		</>
	);
}

CreateCourseModal.propTypes = {
	defaultSchool: PropTypes.string,
	defaultCategory: PropTypes.string,
	schoolsOptions: PropTypes.arrayOf(PropTypes.string),
	onCreated: PropTypes.func,
};

export default CreateCourseModal;