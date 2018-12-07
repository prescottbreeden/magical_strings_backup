import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})

export class HttpService {

  constructor(private _http: HttpClient) {}

  getAllBlogs() {
    return this._http.get('/api/blogs');
  }

  getOneBlog(id: string) {
    return this._http.get('/api/blogs/' + id);
  }

  createBlog(newBlog) {
    return this._http.post('/api/blogs', newBlog);
  }

  editBlog(id: string, editedBlog) {
    return this._http.put('/api/blogs/' + id, editedBlog);
  }

  deleteBlog(id: string) {
    return this._http.delete('/api/blogs/' + id);
  }

}
