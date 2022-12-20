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
    
    getCoins(): Observable<Coin>{
      return this.httpClient.get<Coin>(this.url);
    }
    
}