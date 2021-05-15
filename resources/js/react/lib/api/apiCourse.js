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

const apiCourse = {all, create, update};

export default apiCourse;