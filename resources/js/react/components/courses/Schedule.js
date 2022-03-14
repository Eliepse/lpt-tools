import PropTypes from 'prop-types';
import {Input, Tag} from 'antd';
import {PlusOutlined} from '@ant-design/icons';
import {useEffect, useRef, useState} from 'react';

const Schedule = ({title, hours = [], edit = false, onChange}) => {

	const [inputVisible, setInputVisible] = useState(false);
	const [inputValue, setInputValue] = useState("");
	const inputRef = useRef();

	useEffect(() => {
		if (inputVisible && inputRef.current) {
			inputRef.current.focus();
		}
	}, [inputRef, inputVisible]);

	function deleteHour(index) {
		onChange({key: title, hours: hours.filter((h, i) => i !== index)});
	}

	function addHour() {
		if (!inputVisible || !inputRef.current) {
			return;
		}

		if (hours.includes(inputValue)) {
			return;
		}

		onChange({key: title, hours: [...hours, inputValue]});
		setInputVisible(false);
		setInputValue("");
	}

	function showInput() {
		setInputVisible(true);
	}

	return (
		<>
			<h3>{title}</h3>
			<div className="flex flex-wrap">
				{hours.map((hour, i) => <Tag closable={edit} key={hour} onClose={() => deleteHour(i)}>{hour}</Tag>)}
				{edit && (
					inputVisible ? (
							<Input
								type="text"
								size="small"
								className="w-20"
								ref={inputRef}
								value={inputValue}
								placeholder="12:30"
								onChange={(e) => setInputValue(e.target.value)}
								onBlur={() => setInputVisible(false)}
								onPressEnter={addHour}
							/>
						) :
						<Tag style={{borderStyle: "dashed", background: "white"}} onClick={showInput}><PlusOutlined/>New hour</Tag>
				)}
			</div>
		</>
	);
};

Schedule.propTypes = {
	title: PropTypes.string.isRequired,
	hours: PropTypes.arrayOf(PropTypes.string),
	edit: PropTypes.bool,
	onChange: PropTypes.func.isRequired,
};

export default Schedule;