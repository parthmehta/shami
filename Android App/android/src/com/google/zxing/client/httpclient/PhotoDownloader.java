package com.google.zxing.client.httpclient;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayOutputStream;
import java.io.FilterInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.URL;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.Drawable;
import android.util.Log;
import android.widget.ImageView;

public class PhotoDownloader extends Thread {

	private String url;
	private ImageView iv;
	private String tag = "Photo Downloader";

	// private GalleryApplication app;
	// private String categoryId;
	// private Activity mContext;

	public PhotoDownloader(String url, ImageView iv) {
		// this.mContext = mContext;
		this.url = url;
		this.iv = iv;
		// this.app=app;
		// this.categoryId = categoryId;
	}

	public void run() {
		try {
			Log.d(tag, "url = " + url);
			// InputStream is = (InputStream) new URL(url).getContent();
			// BufferedInputStream bmpBis = new BufferedInputStream(is);
			// Bitmap bmpThumb = null;
			// ByteArrayBuffer baf = new ByteArrayBuffer(128);
			// int current = 0;
			// while ((current = bmpBis.read()) != -1) {
			// baf.append((byte) current);
			// }
			//
			// BitmapFactory.Options bfOpt = new BitmapFactory.Options();
			// bfOpt.inTempStorage = new byte [8 * 1024];
			// // bmpThumb = BitmapFactory.decodeStream(new
			// FlushedInputStream(bmpBis),null,bfOpt);
			// bmpThumb = BitmapFactory.decodeStream(is);
			//
			// if(bmpThumb == null){
			// Log.i(tag, "this photo is null");
			// }
			// //iv.setImageBitmap(ImageHelper.getRoundedCornerBitmap(bmpThumb,
			// 10));
			// iv.setImageBitmap(bmpThumb);

			Drawable drawable = LoadImageFromWebOperations(url);
			iv.setImageDrawable(drawable);

		} catch (Exception e) {
			// TODO: handle exception
			e.printStackTrace();
		}
	}

	private Drawable LoadImageFromWebOperations(String url) {
		try {
			InputStream is = (InputStream) new URL(url).getContent();
			Drawable d = Drawable.createFromStream(is, "src name");
			return d;
		} catch (Exception e) {
			System.out.println("Exc=" + e);
			return null;
		}
	}

	public void loadBitmap(String url) {
		Bitmap bitmap = null;
		InputStream in = null;
		BufferedOutputStream out = null;
		int IO_BUFFER_SIZE = 8 * 1024;

		try {
			in = new BufferedInputStream(new URL(url).openStream(),
					IO_BUFFER_SIZE);

			final ByteArrayOutputStream dataStream = new ByteArrayOutputStream();
			out = new BufferedOutputStream(dataStream, IO_BUFFER_SIZE);
			// copy(in, out);
			// out = in;
			out.flush();

			final byte[] data = dataStream.toByteArray();
			BitmapFactory.Options options = new BitmapFactory.Options();
			// options.inSampleSize = 1;

			bitmap = BitmapFactory.decodeByteArray(data, 0, data.length,
					options);

			iv.setImageBitmap(bitmap);
		} catch (IOException e) {
			// Log.e(TAG, "Could not load Bitmap from: " + url);
		} finally {
			// closeStream(in);
			// closeStream(out);
		}

		// return bitmap;
	}

	static class FlushedInputStream extends FilterInputStream {
		public FlushedInputStream(InputStream inputStream) {
			super(inputStream);
		}

		@Override
		public long skip(long n) throws IOException {
			long totalBytesSkipped = 0L;
			while (totalBytesSkipped < n) {
				long bytesSkipped = in.skip(n - totalBytesSkipped);
				if (bytesSkipped == 0L) {
					int byt = read();
					if (byt < 0) {
						break; // we reached EOF
					} else {
						bytesSkipped = 1; // we read one byte
					}
				}
				totalBytesSkipped += bytesSkipped;
			}
			return totalBytesSkipped;
		}
	}
}
