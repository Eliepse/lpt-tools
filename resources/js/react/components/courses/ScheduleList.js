import Schedule from './Schedule';
import {Button, Input} from 'antd';
import {CheckOutlined, CloseOutlined, PlusOutlined} from '@ant-design/icons';
import {useRef, useState} from 'react';
import PropTypes from 'prop-types';

const _schedulesRegex = new RegExp("^(mon|tue|wed|thu|fri|sat|sun)(-(mon|tue|wed|thu|fri|sat|sun))?$");

function ScheduleList({schedules = {}, edit = false, onChange}) {

	const [addScheduleInput, setAddScheduleInput] = useState(false);
	const newScheduleInputRef = useRef();

	function handleScheduleUpdate(schedule) {
		const newSchedules = {...schedules};
		if (schedule.hours.length === 0) {
			delete newSchedules[schedule.key];
		} else {
			newSchedules[schedule.key] = schedule.hours;
		}
		onChange(newSchedules);
	}

	function showAddScheduleInput() {
		if (!edit) {
			return;
		}

		setAddScheduleInput(true);
	}

	function hideAddScheduleInput() {
		setAddScheduleInput(false);
	}

	function addSchedule(name) {
		// Schedule "day" validation
		if (!_schedulesRegex.test(name)) {
			return;
		}

		const patch = {};
		patch[name] = [];
		onChange({...schedules, ...patch});
		hideAddScheduleInput();
	}

	return (
		<>
			{Object.entries(schedules).map(([day, hours]) =>
				<Schedule key={day} onChange={handleScheduleUpdate} title={day} hours={hours} edit={edit}/>,
			)}
			{edit && (
				<div className="flex mt-4">
					{!addScheduleInput ? (
						<Button type="dashed" icon={
							<PlusOutlined/>} onClick={showAddScheduleInput}>Add schedule</Button>
					) : (<>
						<Input type="text" className="flex-auto" ref={newScheduleInputRef} placeholder="mon, tue, sat, mon-fri, sat-sun"/>
						<Button.Group className="flex-none">
							<Button icon={<CloseOutlined/>} onClick={hideAddScheduleInput}/>
							<Button icon={<CheckOutlined/>} onClick={() => addSchedule(newScheduleInputRef.current.state.value)}/>
						</Button.Group>
					</>)}
				</div>
			)}
		</>
	);
}

ScheduleList.propTypes = {
	schedules: PropTypes.object,
	edit: PropTypes.bool,
	onChange: PropTypes.func.isRequired,
};

export default ScheduleList;