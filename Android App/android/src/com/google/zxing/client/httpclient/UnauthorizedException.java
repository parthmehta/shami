package com.google.zxing.client.httpclient;

public class UnauthorizedException extends Exception{
	String message;
	public UnauthorizedException(String message){
		super();
		this.message=message;
	}
	public String getMessage(){
		return this.message;
	}
}
