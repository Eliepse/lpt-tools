import Fraction from './Fraction';
import PropTypes from 'prop-types';

function Price({value, denominator, edit, onChange}) {
	return (
		<Fraction
			value={value}
			denominator={denominator}
			unit="€"
			options={["year", "month", "week", "day"]}
			onChange={onChange}
			edit={edit}
		/>
	);
}

Price.propTypes = {
	value: PropTypes.number.isRequired,
	edit: PropTypes.bool.isRequired,
	denominator: PropTypes.string.isRequired,
	onChange: PropTypes.func.isRequired,
};

export default Price;