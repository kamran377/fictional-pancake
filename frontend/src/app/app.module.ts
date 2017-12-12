import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule,DeepLinkConfig } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';
import { HttpModule } from '@angular/http';
import { IonicStorageModule } from '@ionic/storage';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { DashboardPage } from '../pages/dashboard/dashboard';
import { VehiclesPage } from '../pages/vehicles/vehicles';
import { AddVehiclePage } from '../pages/add-vehicle/add-vehicle';
import { FuelingsPage } from '../pages/fuelings/fuelings';
import { AddFuelingPage } from '../pages/add-fueling/add-fueling';
import { AddVehicleChecklistPage } from '../pages/add-vehicle-checklist/add-vehicle-checklist';
import { FormsPage } from '../pages/forms/forms';

import { NavbarComponent } from '../components/navbar/navbar';

import { ApiServiceProvider } from '../providers/api-service/api-service';

import { TextAvatarDirective } from '../directives/text-avatar/text-avatar';

export const deepLinkConfig: DeepLinkConfig = {
    links: [
        { component: DashboardPage, name: "DashboardPage", segment: ""},
        { component: FormsPage, name: "FormsPage", segment: "" },
		{ component: AddFuelingPage, name: "AddFuelingPage", segment: "" },
		{ component: AddVehicleChecklistPage, name: "AddVehicleChecklistPage", segment: "" }
    ]
};

@NgModule({
	declarations: [
		MyApp,
		HomePage,
		DashboardPage,
		VehiclesPage,
		AddVehiclePage,
		FuelingsPage,
		AddFuelingPage,
		AddVehicleChecklistPage,
		TextAvatarDirective,
		NavbarComponent,
		FormsPage
	],
	imports: [
		BrowserModule,
		HttpModule,
		IonicModule.forRoot(MyApp, {
			modalEnter: 'modal-slide-in',
			modalLeave: 'modal-slide-out',
			pageTransition: 'ios-transition',
			swipeBackEnabled: false
		},
		 deepLinkConfig),
		IonicStorageModule.forRoot()
	],
	bootstrap: [IonicApp],
	entryComponents: [
		MyApp,
		HomePage,
		DashboardPage,
		VehiclesPage,
		AddVehiclePage,
		FuelingsPage,
		AddFuelingPage,
		AddVehicleChecklistPage,
		FormsPage
	],
	providers: [
		StatusBar,
		SplashScreen,
		{provide: ErrorHandler, useClass: IonicErrorHandler},
		ApiServiceProvider,
		HttpModule
	]
})
export class AppModule {}
