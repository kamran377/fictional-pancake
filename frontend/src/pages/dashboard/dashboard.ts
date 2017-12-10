import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Storage } from '@ionic/storage';
import { HomePage } from '../home/home';
import { AddFuelingPage } from '../add-fueling/add-fueling';

/**
 * Generated class for the DashboardPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-dashboard',
  templateUrl: 'dashboard.html',
})
export class DashboardPage {

  
	constructor(
		public navCtrl: NavController, 
		public navParams: NavParams,
		private storage:Storage,
	
	) {
  
	}

	addFueling() {
		this.navCtrl.push(AddFuelingPage);
	}
	
	logout() {
		let storage = this.storage;
		let env = this;
		storage.get('loggedinuser').then(function (user){
			storage.remove('loggedinuser').then(function (response) {
				storage.remove('user');
				env.navCtrl.setRoot(HomePage);
			});
		});
	}

}
