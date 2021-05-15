import {Button, Checkbox, Form, Input} from 'antd';
import {useAuth} from '../lib/auth/useAuth';

export default function LoginForm() {
	const {login} = useAuth();

	function onFinish(data) {
		login(data.username, data.password, data.remember);
	}

	return (
		<div className="bg-white max-w-2xl p-10 shadow-md w-full">
			<h1 className="mb-8">LPT Admin</h1>
			<Form
				name="basic"
				initialValues={{remember: true}}
				onFinish={onFinish}
			>
				<Form.Item
					label="Username"
					name="username"
					rules={[{required: true, message: 'Please input your username!'}]}
				>
					<Input name="email" autoComplete="email" autoFocus/>
				</Form.Item>

				<Form.Item
					label="Password"
					name="password"
					rules={[{required: true, message: 'Please input your password!'}]}
				>
					<Input.Password/>
				</Form.Item>

				<Form.Item name="remember" valuePropName="checked">
					<Checkbox>Remember me</Checkbox>
				</Form.Item>

				<Form.Item className="mb-0">
					<Button type="primary" htmlType="submit">
						Submit
					</Button>
				</Form.Item>
			</Form>
		</div>
	);
}