import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

// utilities
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';

// pages
import { LandingPageComponent } from './landing-page/landing-page.component';

// components
import { BlogsComponent } from './blogs/blogs.component';
import { CreateBlogComponent } from './dash-board/blog/create-blog/create-blog.component';
import { EditBlogComponent } from './dash-board/blog/edit-blog/edit-blog.component';

const routes: Routes = [
  { path: '', component: LandingPageComponent },
  { path: 'blog', component: BlogsComponent },
  { path: 'newblog', component: CreateBlogComponent },
  { path: 'editblog/:id', component: EditBlogComponent },
  { path: 'error', component: PageNotFoundComponent },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule { }
