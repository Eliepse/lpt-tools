import Api from './broker';

const basePath = "/registrations";

export function all() {
	return Api.get(basePath);
}

export function remove(registration) {
	return Api.delete(`${basePath}/${registration.id}`);
}

const apiCourse = {all, remove};

export default apiCourse;