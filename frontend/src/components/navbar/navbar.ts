import { Component, Input  } from '@angular/core';
import { ApiServiceProvider } from '../../providers/api-service/api-service';
import { NavController } from 'ionic-angular';
import { FormsPage } from '../../pages/forms/forms';
import { Events } from 'ionic-angular';
/**
 * Generated class for the NavbarComponent component.
 *
 * See https://angular.io/api/core/Component for more info on Angular
 * Components.
 */
@Component({
	selector: 'navbar',
	templateUrl: 'navbar.html',
	inputs: ['pageName']
})
export class NavbarComponent {

	permissions = [];
	
	constructor(
		public navCtrl: NavController, 
		public apiService: ApiServiceProvider,
		public events: Events
	) {
		
	}
	
	updateMenu(linkObj) {
		let pages = [];
		console.log(linkObj);
		for(var i=0;i < linkObj.childLinks.length; i++) {
			let l = linkObj.childLinks[i];
			pages.push({ title: l.name, icon: '', component: l.pageName });
		}
		console.log(pages);
		this.events.publish('menu:changed', pages, linkObj.name);
		this.navCtrl.setRoot(linkObj.pageName);
	}

}
