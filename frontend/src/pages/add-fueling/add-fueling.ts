import { Component } from '@angular/core';
import { NavController, NavParams, LoadingController, ToastController, } from 'ionic-angular';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
import { Validators, FormBuilder, FormGroup, FormControl } from '@angular/forms';

/**
 * Generated class for the AddFuelingPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-add-fueling',
  templateUrl: 'add-fueling.html',
})
export class AddFuelingPage {

	fuelingForm: FormGroup;
	vehicles = [];
	accounts = [];
	receipt:any;
	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams,
		public formBuilder: FormBuilder,
		public loadingCtrl: LoadingController,
		public toastCtrl: ToastController,
		public apiService: ApiServiceProvider,
	) {
		this.fuelingForm = this.formBuilder.group({
			fueling_date: new FormControl('', Validators.required),
			cost: new FormControl('', Validators.required),
			odometer_reading: new FormControl('', Validators.required),
			vehicle_id: new FormControl('', Validators.required),
			gallons: new FormControl('', Validators.required),
			account_id: new FormControl('', Validators.required),
			
		});
		
	}
	

	
	validation_messages = {
		'fueling_date': [
			{ type: 'required', message: 'Fueling Date is required.' }
		],
		'cost': [
			{ type: 'required', message: 'Fueling Cost is required.' }
		],
		'odometer_reading': [
			{ type: 'required', message: 'Vehicle Odometer Reading is required.' }
		],
		'vehicle_id': [
			{ type: 'required', message: 'Vehicle is required.' }
		],
		'account_id': [
			{ type: 'required', message: 'Account is required.' }
		],
		'gallons': [
			{ type: 'required', message: 'Gallons is required.' }
		],
		
	};

	getFiles(event){ 
        this.receipt = event.target.files[0]; 
    } 
	
	ionViewDidLoad() {
		let me = this;
		let loadingCtrl = this.loadingCtrl;
		let loading = loadingCtrl.create();
		loading.present();
		me.apiService.getVehiclesSelectList()
		.then(function(data){
			let response = JSON.parse(JSON.stringify(data));
			me.vehicles = response.data.vehicles;
			me.apiService.getAccountsSelectList()
			.then(function(data){
				loading.dismiss();
				let response = JSON.parse(JSON.stringify(data));
				me.accounts = response.data.accounts;
			}, function(error){
				alert(error);
				loading.dismiss();
			});
		}, function(error){
			alert(error);
			loading.dismiss();
		});
		
	}
	
	cancel() {
		this.fuelingForm.reset();
		(<HTMLInputElement>document.getElementById('receipt')).value = "";
	}
	
	onSubmit(values){
		let loadingCtrl = this.loadingCtrl;
		let toastCtrl = this.toastCtrl;
		let loading = loadingCtrl.create();
		values.receipt = this.receipt;
		console.log(values);
		loading.present();
		let me = this;
		
		this.apiService.saveFueling(values)
		.then(data => {
			loading.dismiss();
			let response = JSON.parse(JSON.stringify(data));	
			console.log(response);
			console.log(response.status);
			if(response.status == "success") {
				
				let toast = toastCtrl.create({
					message: "Fueling saved successfully!",
					duration: 3000,
					cssClass: 'toast-success',
					position:'top',
				});
				toast.present();
				me.fuelingForm.reset();
				(<HTMLInputElement>document.getElementById('receipt')).value = "";
			} else {
				let toast = toastCtrl.create({
					message: response.message,
					duration: 3000,
					cssClass: 'toast-error',
					position:'top',
				});
				toast.present();
				
			}
			//console.log(data.login);
		});
		
	}

}
