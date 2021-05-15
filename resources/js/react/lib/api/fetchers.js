export function getCsrfToken() {
	const cookies = Object.fromEntries(document.cookie.split(";").map((cookie) => cookie.split("=")));
	return decodeURIComponent(cookies["XSRF-TOKEN"]);
}