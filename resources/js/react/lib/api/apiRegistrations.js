import Api from './broker';

const basePath = "/registrations";

export function all() {
	return Api.get(basePath);
}

const apiCourse = {all};

export default apiCourse;