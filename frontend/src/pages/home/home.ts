import { Component } from '@angular/core';
import { NavController, LoadingController, ToastController } from 'ionic-angular';
import { Validators, FormGroup, FormControl } from '@angular/forms';
import 'rxjs/add/operator/toPromise';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
import { EmailValidator} from '../../validators/email-validator/email-validator';
import "rxjs/Rx";
import { Storage } from '@ionic/storage';

import { DashboardPage } from '../dashboard/dashboard';
@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
	login: FormGroup;
	main_page: { component: any };
	loading: any;


	constructor(
		public nav: NavController,
		public loadingCtrl: LoadingController,
		public toastCtrl: ToastController,
		public apiService: ApiServiceProvider,
		public storage:Storage,
		

	) {
		//this.main_page = { component: TabsNavigationPage };

		this.login = new FormGroup({
			email: new FormControl('', Validators.compose([Validators.required,EmailValidator.isValid])),
			password: new FormControl('', Validators.required)
		});
	}
	
	validation_messages = {
		'email': [
			{ type: 'required', message: ' Email Address is required.' },
			{ type: 'invalidEmail', message: 'Must be a valid Email Address.' }
		],
		'password': [
			{ type: 'required', message: 'Password is required.' }
		],
	};

	doLogin(values){
		console.log(values);
		let loadingCtrl = this.loadingCtrl;
		let toastCtrl = this.toastCtrl;
		let loading = loadingCtrl.create();
		let nav = this.nav;
		loading.present();
		let me = this;
		this.apiService.login(values)
		.then(data => {
			loading.dismiss();
			let response = JSON.parse(JSON.stringify(data));				
			if(response.status == "success") {
				let dUser = response.data.user;
				let dUserDetails = response.data.userDetails;
				me.apiService.user = dUser;
				me.apiService.userDetails = dUserDetails;
				me.storage.set('loggedinuser',{
					'user' : dUser,
					'userDetails' : dUserDetails		
				}).then(function (){
					let toast = toastCtrl.create({
						message: "Login Successfull",
						duration: 3000,
						cssClass: 'toast-success',
						position:'bottom',
					});
					toast.present();
					nav.setRoot(DashboardPage);
				});
			} else {
				let toast = toastCtrl.create({
					message: "Email/Password is not correct",
					duration: 3000,
					cssClass: 'toast-error',
					position:'bottom',
				});
				toast.present();
				
			}
			//console.log(data.login);
		});
		//
	}

}
