import { Component, ViewChild  } from '@angular/core';
import { Platform, MenuController, Nav, App,  } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { AddFuelingPage } from '../pages/add-fueling/add-fueling';
import { Storage } from '@ionic/storage';
import { ApiServiceProvider } from '../providers/api-service/api-service';

import { HomePage } from '../pages/home/home';
@Component({
  templateUrl: 'app.html'
})
export class MyApp {
	rootPage:any = HomePage;
	pages: Array<{ title: any, icon: string, component: any }>;
	@ViewChild(Nav) nav: Nav;
	
	constructor(
		platform: Platform, 
		statusBar: StatusBar, 
		splashScreen: SplashScreen,
		public menu: MenuController,
		public app: App,
		public apiService: ApiServiceProvider,
		public storage : Storage,
    
	) {
		platform.ready().then(() => {
			// Okay, so the platform is ready and our plugins are available.
			// Here you can do any higher level native things you might need.
			statusBar.styleDefault();
			splashScreen.hide();
		});
		
		let env = this;
		this.storage.get('loggedinuser').then(function (data){
			splashScreen.hide();
			if(data == null || data.user == null) {
				env.rootPage = HomePage;
			} else {
				env.apiService.user = data.user;
				env.apiService.userDetails = data.userDetails;
				
				env.rootPage = AddFuelingPage;			}
		});
		
	}
	
	openPage(page) {
		// close the menu when clicking a link from the menu
		this.menu.close();
		// navigate to the new page if it is not the current page
		this.nav.setRoot(page.component);
	}
}

