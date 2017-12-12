import { Component } from '@angular/core';
import { NavController, NavParams, LoadingController, ToastController, } from 'ionic-angular';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
import { Validators, FormBuilder, FormGroup, FormControl } from '@angular/forms';

/**
 * Generated class for the AddVehicleChecklistPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-add-vehicle-checklist',
  templateUrl: 'add-vehicle-checklist.html',
})
export class AddVehicleChecklistPage {

	checklistForm: FormGroup;
	vehicles = [];
	receipt:any;
	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams,
		public formBuilder: FormBuilder,
		public loadingCtrl: LoadingController,
		public toastCtrl: ToastController,
		public apiService: ApiServiceProvider,
	) {
		this.checklistForm = this.formBuilder.group({
			inspection_date: new FormControl('', Validators.required),
			odometer_reading: new FormControl('', Validators.required),
			vehicle_id: new FormControl('', Validators.required),
			accident_report_checked: new FormControl('0', []),
			accident_report_na: new FormControl('0', []),
			accident_report_repairs: new FormControl('0', []),
			accident_report_comments: new FormControl('', Validators.required),
			
			vehicle_inspection_checked: new FormControl('0', []),
			vehicle_inspection_na: new FormControl('0', []),
			vehicle_inspection_repairs: new FormControl('0', []),
			vehicle_inspection_comments: new FormControl('', Validators.required),
			
			vehicle_registration_checked: new FormControl('0', []),
			vehicle_registration_na: new FormControl('0', []),
			vehicle_registration_repairs: new FormControl('0', []),
			vehicle_registration_comments: new FormControl('', Validators.required),
			
			insurance_information_checked: new FormControl('0', []),
			insurance_information_na: new FormControl('0', []),
			insurance_information_repairs: new FormControl('0', []),
			insurance_information_comments: new FormControl('', Validators.required),
			
			tires_checked: new FormControl('0', []),
			tires_na: new FormControl('0', []),
			tires_repairs: new FormControl('0', []),
			tires_comments: new FormControl('', Validators.required),
			
			engine_checked: new FormControl('0', []),
			engine_na: new FormControl('0', []),
			engine_repairs: new FormControl('0', []),
			engine_comments: new FormControl('', Validators.required),
			
			steering_checked: new FormControl('0', []),
			steering_na: new FormControl('0', []),
			steering_repairs: new FormControl('0', []),
			steering_comments: new FormControl('', Validators.required),
			
			horn_checked: new FormControl('0', []),
			horn_na: new FormControl('0', []),
			horn_repairs: new FormControl('0', []),
			horn_comments: new FormControl('', Validators.required),
			
			mirrors_checked: new FormControl('0', []),
			mirrors_na: new FormControl('0', []),
			mirrors_repairs: new FormControl('0', []),
			mirrors_comments: new FormControl('', Validators.required),
			
			fak_checked: new FormControl('0', []),
			fak_na: new FormControl('0', []),
			fak_repairs: new FormControl('0', []),
			fak_comments: new FormControl('', Validators.required),
			
			fe_checked: new FormControl('0', []),
			fe_na: new FormControl('0', []),
			fe_repairs: new FormControl('0', []),
			fe_comments: new FormControl('', Validators.required),
			
			windshield_checked: new FormControl('0', []),
			windshield_na: new FormControl('0', []),
			windshield_repairs: new FormControl('0', []),
			windshield_comments: new FormControl('', Validators.required),
			
			lights_checked: new FormControl('0', []),
			lights_na: new FormControl('0', []),
			lights_repairs: new FormControl('0', []),
			lights_comments: new FormControl('', Validators.required),
			
			signals_checked: new FormControl('0', []),
			signals_na: new FormControl('0', []),
			signals_repairs: new FormControl('0', []),
			signals_comments: new FormControl('', Validators.required),
			
			brake_lights_checked: new FormControl('0', []),
			brake_lights_na: new FormControl('0', []),
			brake_lights_repairs: new FormControl('0', []),
			brake_lights_comments: new FormControl('', Validators.required),
			
			condition_checked: new FormControl('0', []),
			condition_na: new FormControl('0', []),
			condition_repairs: new FormControl('0', []),
			condition_comments: new FormControl('', Validators.required),
			
			computer_checked: new FormControl('0', []),
			computer_na: new FormControl('0', []),
			computer_repairs: new FormControl('0', []),
			computer_comments: new FormControl('', Validators.required),
			
			key_checked: new FormControl('0', []),
			key_na: new FormControl('0', []),
			key_repairs: new FormControl('0', []),
			key_comments: new FormControl('', Validators.required),
			
			gas_can_checked: new FormControl('0', []),
			gas_can_na: new FormControl('0', []),
			gas_can_repairs: new FormControl('0', []),
			gas_can_comments: new FormControl('', Validators.required),
			
			inverter_checked: new FormControl('0', []),
			inverter_na: new FormControl('0', []),
			inverter_repairs: new FormControl('0', []),
			inverter_comments: new FormControl('', Validators.required),
			
			hammer_checked: new FormControl('0', []),
			hammer_na: new FormControl('0', []),
			hammer_repairs: new FormControl('0', []),
			hammer_comments: new FormControl('', Validators.required),
			
			brush_checked: new FormControl('0', []),
			brush_na: new FormControl('0', []),
			brush_repairs: new FormControl('0', []),
			brush_comments: new FormControl('', Validators.required),
			
			bucket_checked: new FormControl('0', []),
			bucket_na: new FormControl('0', []),
			bucket_repairs: new FormControl('0', []),
			bucket_comments: new FormControl('', Validators.required),
			
			kit_checked: new FormControl('0', []),
			kit_na: new FormControl('0', []),
			kit_repairs: new FormControl('0', []),
			kit_comments: new FormControl('', Validators.required),
			
			pads_checked: new FormControl('0', []),
			pads_na: new FormControl('0', []),
			pads_repairs: new FormControl('0', []),
			pads_comments: new FormControl('', Validators.required),
			
			wrench_checked: new FormControl('0', []),
			wrench_na: new FormControl('0', []),
			wrench_repairs: new FormControl('0', []),
			wrench_comments: new FormControl('', Validators.required),
			
		});
		
	}
	
	validation_messages = {
		'inspection_date': [
			{ type: 'required', message: 'Fueling Date is required.' }
		],
		'odometer_reading': [
			{ type: 'required', message: 'Vehicle Odometer Reading is required.' }
		],
		'vehicle_id': [
			{ type: 'required', message: 'Vehicle is required.' }
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
			loading.dismiss();
		}, function(error){
			alert(error);
			loading.dismiss();
		});
		
	}
	
	cancel() {
		this.checklistForm.reset();
		(<HTMLInputElement>document.getElementById('receipt')).value = "";
	}

}
