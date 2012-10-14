package com.google.zxing.client.httpclient;

public class NetworkUnavailableException extends Exception{
	String message;
	public NetworkUnavailableException(String message){
		super();
		this.message=message;
	}
	public String getMessage(){
		return this.message;
	}
	
}
