import {Input, Select} from 'antd';
import PropTypes from 'prop-types';

const Fraction = ({value, denominator, unit, onChange, options = [], edit = false}) => {

	if (!edit) {
		return <p>{value} {unit} / {denominator}</p>;
	}

	return (
		<div className="flex">
			<Input
				pattern="[0-9]+"
				addonAfter={unit}
				min={1}
				value={value}
				precision={0}
				style={{maxWidth: "8rem"}}
				onChange={(e) => onChange({value: Number(e.target.value), denominator})}
			/>
			<span className="mx-4">/</span>
			<Select value={denominator} onChange={(val) => onChange({value, denominator: val})}>
				{options.map((name) => <Select.Option key={name} value={name}>{name}</Select.Option>)}
			</Select>
		</div>
	);
};

Fraction.propTypes = {
	value: PropTypes.number.isRequired,
	denominator: PropTypes.string.isRequired,
	unit: PropTypes.string.isRequired,
	onChange: PropTypes.func.isRequired,
	options: PropTypes.arrayOf(PropTypes.string).isRequired,
};

export default Fraction;