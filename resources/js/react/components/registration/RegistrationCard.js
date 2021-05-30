import {Tag, Typography} from 'antd';
import styles from "./RegistrationCard.module.scss";
import dayjs from 'dayjs';
import {ClockCircleOutlined, EuroCircleOutlined, HomeOutlined, PhoneOutlined, WechatOutlined} from '@ant-design/icons';
import clsx from 'clsx';

const {Text} = Typography;

function RegistrationCard({registration}) {
	const {student, contact, school, category, schedule, course} = registration;

	const birthday = dayjs(student.birthday);
	const createdAt = dayjs(registration.created_at);

	return (
		<div className={styles.card}>
			<div className={clsx(styles.column, "flex flex-col")}>
				<div className="flex-auto mb-4">
					<div className="font-bold text-lg capitalize leading-none">{student.firstname} {student.lastname}</div>
					<div className="text-sm text-gray-400">{student.fullname_cn}</div>
					{birthday.format("YYYY-MM-DD")}<br/>
					({dayjs().diff(birthday, "year")} years old)
				</div>
				<div className="text-xs text-gray-400">
					Created at {createdAt.format("YYYY-MM-DD")}<br/>
					({createdAt.fromNow()})
				</div>
			</div>
			<div className={styles.column}>
				<p className="uppercase text-xs text-gray-400">Contact</p>
				<p>
					<PhoneOutlined className="mr-2"/>{contact.phone_1}<br/>
					<PhoneOutlined className="mr-2"/>{contact.phone_2}<br/>
					<WechatOutlined className="mr-2"/>{contact.wechat_1}<br/>
					<HomeOutlined className="mr-2"/>{student.city_code}
				</p>
			</div>
			<div className={clsx(styles.column, "flex-auto")}>
				<p className="uppercase text-xs text-gray-400">Course</p>
				<p>
					<span className="font-bold">{course.name}</span><Tag className="ml-2">{category}</Tag><br/>
					<HomeOutlined className="mr-2"/>{school}<br/>
					<EuroCircleOutlined className="mr-2"/>{course.price} / {course.price_denominator}<br/>
					<ClockCircleOutlined className="mr-2"/>{course.duration} / {course.duration_denominator}<br/>
					<Tag className="mt-2">{schedule.days} {schedule.hour}</Tag>
				</p>
			</div>
			<div className={clsx(styles.column, styles.actions)}>
				<span className="text-gray-400 text-xs uppercase">ID: {registration.uid}</span>
				{/*<Button>Bout de thon</Button>*/}
			</div>
		</div>
	);
}

export default RegistrationCard;