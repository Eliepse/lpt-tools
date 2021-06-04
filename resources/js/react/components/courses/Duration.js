import Fraction from './Fraction';
import PropTypes from 'prop-types';

function Duration({value, denominator, edit, onChange}) {
	return (
		<Fraction
			value={value}
			denominator={denominator}
			unit="min"
			options={["year", "month", "week", "day"]}
			onChange={onChange}
			edit={edit}
		/>
	);
}

Duration.propTypes = {
	value: PropTypes.number.isRequired,
	edit: PropTypes.bool.isRequired,
	denominator: PropTypes.string.isRequired,
	onChange: PropTypes.func.isRequired,
};

export default Duration;