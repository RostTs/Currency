import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Coin } from '../interfaces/coin.interface';
import { Observable } from 'rxjs';
import {HttpResponse} from "@angular/common/http";

@Injectable({
    providedIn: 'root'
  })

export class CoinsService {
    //TODO: change host
    private url = 'http://localhost:8050/api/list';

    constructor(private httpClient: HttpClient) { }

   public getCoins(pageSize: number = null, page: number = null): Observable<HttpResponse<Coin[]>>{
      let url = this.buildUrl({'pageSize': pageSize, 'page': page});
      return this.httpClient.get<Coin[]>(url, {observe: 'response'});
    }

   private buildUrl(params: any): string {
    let url = new URL(this.url);
    let urlParams = url.searchParams;
     for (const [key, value] of Object.entries(params)) {
       if (value) {
         urlParams.set(key, value.toString());
       }
     }
     url.search = urlParams.toString();

     return url.toString();
   }

}
