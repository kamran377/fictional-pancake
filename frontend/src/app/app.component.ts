import { Component, ViewChild  } from '@angular/core';
import { Platform, MenuController, Nav, App,  } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { AddFuelingPage } from '../pages/add-fueling/add-fueling';
import { Storage } from '@ionic/storage';
import { ApiServiceProvider } from '../providers/api-service/api-service';

import { HomePage } from '../pages/home/home';
import { DashboardPage } from '../pages/dashboard/dashboard';
import { Events } from 'ionic-angular';
@Component({
  templateUrl: 'app.html'
})
export class MyApp {
	rootPage:any = HomePage;
	pages: Array<{ title: any, icon: string, component: any }>;
	@ViewChild(Nav) nav: Nav;
	menuTitle:any = "menu";

	
	constructor(
		platform: Platform, 
		statusBar: StatusBar, 
		splashScreen: SplashScreen,
		public menu: MenuController,
		public app: App,
		public apiService: ApiServiceProvider,
		public storage : Storage,
		public events: Events
	) {
		platform.ready().then(() => {
			// Okay, so the platform is ready and our plugins are available.
			// Here you can do any higher level native things you might need.
			statusBar.styleDefault();
			splashScreen.hide();
		});
		/*this.pages = [
			{ title: 'Dashboard', icon: 'home', component: DashboardPage },
			{ title: 'Fueling Service', icon: 'clipboard', component: AddFuelingPage },
			{ title: 'Vehicle Checklist', icon: 'checkmark', component: AddVehicleChecklistPage },
		];*/
		let env = this;
		this.storage.get('loggedinuser').then(function (data){
			splashScreen.hide();
			if(data == null || data.user == null) {
				env.rootPage = HomePage;
			} else {
				env.apiService.user = data.user;
				env.apiService.userDetails = data.userDetails;				
				env.rootPage = DashboardPage;	
				env.apiService.getLinks()
				.then(function(data){
					let response = JSON.parse(JSON.stringify(data));	
					env.apiService.links = response.data.links;		
				});
			}
		});
		events.subscribe('menu:changed', (pages, menuTitle) => {
			this.pages = pages;
			this.menuTitle = menuTitle;
		});
	}
	
	openPage(page) {
		// close the menu when clicking a link from the menu
		this.menu.close();
		// navigate to the new page if it is not the current page
		this.nav.push(page.component);
	}
}

