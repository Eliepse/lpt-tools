import Api from './broker';

const basePath = "/courses";

export function all() {
	return Api.get(basePath);
}

export function create(course) {
	return Api.post(basePath, course);
}

export function update(course) {
	return Api.put(`${basePath}/${course.id}`, course);
}

export function remove(course) {
	return Api.delete(`${basePath}/${course.id}`);
}

const apiCourse = {all, create, update, remove};

export default apiCourse;