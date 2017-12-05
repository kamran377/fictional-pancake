import { Http, Headers } from '@angular/http';
import { Injectable } from '@angular/core';
/*
  Generated class for the ApiServiceProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class ApiServiceProvider {

	constructor(public http: Http) {
		console.log(this.baseUrl);
	}
	
	public user;
	public userDetails;
	//private baseUrl = "http://localhost:7777/api/";
	private baseUrl = "http://138.68.7.255/backend/web/index.php/api/";

	fullUrl(url) {
		return this.baseUrl + url;
	}
	
	saveVehicle(postData) {
		let url = this.fullUrl("vehicle/save");
		let body = new FormData();
		body.append('name', postData.name);
		body.append('number', postData.number);
		if(postData.id) {
			body.append('id', postData.id);
		}
		return  this.authorizedRequest(url, body);
	}
	
	getVehicles(offset) {
		let url = this.fullUrl("vehicle/list");
		let body = new FormData();
		body.append('offset', offset);
		return  this.authorizedRequest(url, body);
	}
	
	getVehiclesSelectList() {
		let url = this.fullUrl("vehicle/select-list");
		let body = new FormData();
		return  this.authorizedRequest(url, body);
	}
	
	deleteVehicle(id) {
		let url = this.fullUrl("vehicle/delete-vehicle");
		let body = new FormData();
		body.append('id', id);
		return  this.authorizedRequest(url, body);
	}
	
	
	getFuelings(offset) {
		let url = this.fullUrl("fueling/list");
		let body = new FormData();
		body.append('offset', offset);
		return  this.authorizedRequest(url, body);
	}
	
	saveFueling(postData) {
		let url = this.fullUrl("fueling/save");
		let body = new FormData();
		body.append('fueling_date', postData.fueling_date);
		body.append('cost', postData.cost);
		body.append('odometer_reading', postData.odometer_reading);
		body.append('vehicle_id', postData.vehicle_id);
		body.append('gallons', postData.gallons);
		return  this.authorizedRequest(url, body);
	}
	
	deleteFueling(id) {
		let url = this.fullUrl("fueling/delete-fueling");
		let body = new FormData();
		body.append('id', id);
		return  this.authorizedRequest(url, body);
	}
	
	
	authorizedRequest(url, formData) {
		let token = this.user.whoseme_token;
		return new Promise((resolve, reject) => {
			let headers = new Headers();
			//headers.append("Accept","application/json");
			//headers.append('Authorization', 'Bearer ' + token);
			url = url + "?access-token=" + token;
			this.http.post(url, formData)
			.subscribe(res => {
				resolve(res.json());
			}, (err) => {
				reject(err);
			});
		});
	}
	
	login(postData) {
		let url = this.fullUrl("users/login");
		let body = new FormData();
		body.append('email', postData.email);
		body.append('password', postData.password);
		
		return new Promise((resolve, reject) => {
			let headers = new Headers();
			headers.append("Accept","application/json");
			this.http.post(url, body, {headers: headers})
			.subscribe(res => {
				resolve(res.json());
			}, (err) => {
				reject(err);
			});
		});
	}
}
