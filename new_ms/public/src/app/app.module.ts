import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpService } from './http.service';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { DashBoardComponent } from './dash-board/dash-board.component';
import { CreateBlogComponent } from './dash-board/blog/create-blog/create-blog.component';
import { EditBlogComponent } from './dash-board/blog/edit-blog/edit-blog.component';
import { LandingPageComponent } from './landing-page/landing-page.component';
import { BlogsComponent } from './blogs/blogs.component';

@NgModule({
  declarations: [
    AppComponent,
    CreateBlogComponent,
    PageNotFoundComponent,
    EditBlogComponent,
    DashBoardComponent,
    LandingPageComponent,
    BlogsComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [HttpService],
  bootstrap: [AppComponent]
})
export class AppModule { }
