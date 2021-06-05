import Api from './broker';

const basePath = "/registrations";

export function all() {
	return Api.get(basePath);
}

export function remove(registration) {
	return Api.delete(`${basePath}/${registration.id}`);
}

export function review(registration, state) {
	return Api.post(`${basePath}/${registration.id}/review`, {state});
}

const apiCourse = {all, remove, review};

export default apiCourse;