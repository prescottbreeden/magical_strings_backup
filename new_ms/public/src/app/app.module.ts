import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BlogService } from './services/blog.service';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PageNotFoundComponent } from './components/page-not-found/page-not-found.component';
import { DashBoardComponent } from './components/dash-board/dash-board.component';
import { LandingPageComponent } from './components/landing-page/landing-page.component';
import { EventsShowComponent } from './components/events/events-show/events-show.component';

@NgModule({
  declarations: [
    AppComponent,
    PageNotFoundComponent,
    DashBoardComponent,
    LandingPageComponent,
    EventsShowComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [BlogService],
  bootstrap: [AppComponent]
})
export class AppModule { }
