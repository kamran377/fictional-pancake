import { Component } from '@angular/core';
import { Validators, FormBuilder, FormGroup, FormControl } from '@angular/forms';
import { NavController, NavParams, LoadingController, ToastController, } from 'ionic-angular';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
/**
 * Generated class for the AddVehiclePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-add-vehicle',
  templateUrl: 'add-vehicle.html',
})
export class AddVehiclePage {

	vehicleForm: FormGroup;
	vehicleObject;
	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams,
		public formBuilder: FormBuilder,
		public loadingCtrl: LoadingController,
		public toastCtrl: ToastController,
		public apiService: ApiServiceProvider,
		
	) {
		this.vehicleObject = this.navParams.get('vehicleObject');
		this.vehicleForm = this.formBuilder.group({
			name: new FormControl('', Validators.required),
			number: new FormControl('', Validators.required),
		});
	}
	
	ionViewDidEnter() {
		if(this.vehicleObject) {
			this.vehicleForm.get('name').setValue(this.vehicleObject.name);
			this.vehicleForm.get('number').setValue(this.vehicleObject.number);
		}	
	}
	
	validation_messages = {
		'name': [
			{ type: 'required', message: 'Vehicle Name is required.' }
		],
		'number': [
			{ type: 'required', message: 'Vehicle Number is required.' }
		],
	};

	cancel() {
		this.navCtrl.pop();
	}
	
	onSubmit(values){
		let loadingCtrl = this.loadingCtrl;
		let toastCtrl = this.toastCtrl;
		let loading = loadingCtrl.create();
		loading.present();
		let me = this;
		
		console.log(values);
		if(this.vehicleObject) {
			values.id = this.vehicleObject.id;
		}
		this.apiService.saveVehicle(values)
		.then(data => {
			loading.dismiss();
			let response = JSON.parse(JSON.stringify(data));				
			if(response.status == "success") {
				
				let toast = toastCtrl.create({
					message: "Vehicle saved successfully!",
					duration: 3000,
					cssClass: 'toast-success',
					position:'top',
				});
				toast.present();
				me.navCtrl.pop();
			} else {
				let toast = toastCtrl.create({
					message: response.error,
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
