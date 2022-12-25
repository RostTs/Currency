import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Coin } from '../interfaces/coin.interface';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
  })

export class CoinsService {
    //TODO: change host
    private url = 'http://localhost:8050/api/list';
     
    constructor(private httpClient: HttpClient) { }
    
   public getCoins(pageSize: number = null, page: number = null): Observable<Coin[]>{
      let url = this.buildUrl({'pageSize': pageSize, 'page': page});
      return this.httpClient.get<Coin[]>(this.url);
    }

   private buildUrl(params: any) {
    let url = new URL(this.url);
    let urlParams = url.searchParams;
      // params.forEach((param) => {
      //   if (param) {
      //     url = url + ''
      //   }
      // });
   } 
    
}