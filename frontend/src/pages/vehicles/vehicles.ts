import { Component } from '@angular/core';
import { NavController, NavParams, LoadingController, AlertController, ToastController  } from 'ionic-angular';
import { AddVehiclePage } from '../add-vehicle/add-vehicle';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
/**
 * Generated class for the VehiclesPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-vehicles',
  templateUrl: 'vehicles.html',
})
export class VehiclesPage {

	vehicles = [];
	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams,
		public loadingCtrl: LoadingController,
		public alertCtrl: AlertController,
		public apiService: ApiServiceProvider,
		public toastCtrl: ToastController,	
	) {
  
	}

	ionViewDidEnter() {
		let me = this;
		let loadingCtrl = this.loadingCtrl;
		let loading = loadingCtrl.create();
		loading.present();
		me.apiService.getVehicles(0)
		.then(function(data){
			loading.dismiss();
			let response = JSON.parse(JSON.stringify(data));
			me.vehicles = response.data.vehicles;
		}, function(error){
			alert(error);
			loading.dismiss();
		});
	}
	
	addVehicle() {
		this.navCtrl.push(AddVehiclePage);
	}
	
	editVehicle(vehicle) {
		this.navCtrl.push(AddVehiclePage, {'vehicleObject' : vehicle});
	}
	
	doInfinite(infiniteScroll) {
		console.log('Begin async operation');
		let offset = this.vehicles.length;
		let me = this;
		let loadingCtrl = this.loadingCtrl;
		let loading = loadingCtrl.create();
		loading.present();
		me.apiService.getVehicles(offset)
		.then(function(data){
			let response = JSON.parse(JSON.stringify(data));
			if(response.data.jobs) {
				me.vehicles = me.vehicles.concat(response.data.vehicles);
			}
			console.log('Async operation has ended');
			infiniteScroll.complete();
			loading.dismiss();
		}, function(error){
			alert(error);
			infiniteScroll.complete();
			loading.dismiss();
		});
		
	}
	
	deleteVehicle(vehicle) {
		let toastCtrl = this.toastCtrl;
		let me = this;
		let loading = this.loadingCtrl.create({
			content: 'Please wait ...'
		});
		
		let alert1 = this.alertCtrl.create({
			title: 'Confirm Delete',
			message: 'Do you really want to delete this vehicle?',
			buttons: [
				{
					text: 'Cancel',
					role: 'cancel',
					handler: () => {
						console.log('Cancel clicked');
					}
				},
				{
					text: 'Delete',
					handler: () => {
						loading.present();
						let id = vehicle.id;
						me.apiService.deleteVehicle(vehicle.id)
						.then(function(data){
							loading.dismiss();
							let response = JSON.parse(JSON.stringify(data));
							if(response.status == "success") 
							{
								for(var i =0; i< me.vehicles.length; i++) {
									let m = me.vehicles[i];
									if(m.id == id) {
										if (i > -1) {
										   me.vehicles.splice(i, 1);
										}
									}
								}
								let toast = toastCtrl.create({
									message: response.message,
									duration: 3000,
									cssClass: 'toast-success',
									position:'top',
								});
								toast.present();	
							} 
							else 
							{
								let toast = toastCtrl.create({
									message: response.message,
									duration: 3000,
									cssClass: 'toast-error',
									position:'top',
								});
								toast.present();
								
							}
						});
					}
				}
			]
		});
		alert1.present();
	}

}
