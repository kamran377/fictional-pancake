import { Component } from '@angular/core';
import { NavController, NavParams, LoadingController, AlertController, ToastController   } from 'ionic-angular';
import { AddFuelingPage } from '../add-fueling/add-fueling';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
/**
 * Generated class for the FuelingsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-fuelings',
  templateUrl: 'fuelings.html',
})
export class FuelingsPage {

	fuelings = [];
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
		me.apiService.getFuelings(0)
		.then(function(data){
			loading.dismiss();
			let response = JSON.parse(JSON.stringify(data));
			me.fuelings = response.data.fuelings;
		}, function(error){
			alert(error);
			loading.dismiss();
		});
	}
	
	addFueling() {
		this.navCtrl.push(AddFuelingPage);
	}
	
	doInfinite(infiniteScroll) {
		console.log('Begin async operation');
		let offset = this.fuelings.length;
		let me = this;
		let loadingCtrl = this.loadingCtrl;
		let loading = loadingCtrl.create();
		loading.present();
		me.apiService.getFuelings(offset)
		.then(function(data){
			let response = JSON.parse(JSON.stringify(data));
			if(response.data.jobs) {
				me.fuelings = me.fuelings.concat(response.data.fuelings);
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
	
	deleteFueling(fueling) {
		let toastCtrl = this.toastCtrl;
		let me = this;
		let loading = this.loadingCtrl.create({
			content: 'Please wait ...'
		});
		
		let alert1 = this.alertCtrl.create({
			title: 'Confirm Delete',
			message: 'Do you really want to delete this fueling?',
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
						let id = fueling.id;
						me.apiService.deleteFueling(fueling.id)
						.then(function(data){
							loading.dismiss();
							let response = JSON.parse(JSON.stringify(data));
							if(response.status == "success") 
							{
								for(var i =0; i< me.fuelings.length; i++) {
									let m = me.fuelings[i];
									if(m.id == id) {
										if (i > -1) {
										   me.fuelings.splice(i, 1);
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
