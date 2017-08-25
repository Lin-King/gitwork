package com.starssoft.myapplication.widget;

import android.animation.Animator;
import android.animation.ValueAnimator;
import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Path;
import android.graphics.PathMeasure;
import android.graphics.RectF;
import android.graphics.Typeface;
import android.support.annotation.Nullable;
import android.text.TextPaint;
import android.util.AttributeSet;
import android.view.MotionEvent;
import android.view.View;
import android.view.animation.DecelerateInterpolator;
import android.widget.Toast;

import com.starssoft.myapplication.app.MyApplication;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Lin on 2017/8/24.
 * Time: 11:05
 * Description: TOO
 */

public class SwitchBar extends View {

    private Paint mPaint;
    private RectF mRectF;
    private TextPaint mTextPaint;
    private int mTotalHeight;
    private int mTotalleft;
    private int mTotalTop;
    private int mTotalRight;
    private int mTotalBottom;
    private int mBaseLineY;
    private float[] mCurrentPosition = new float[2];//遮盖物的坐标点
    private int colorRed = Color.rgb(0xff, 0x21, 0x10);
    private int colorPurple = Color.rgb(0x88, 0x88, 0xff);
    private float mOverlayRadius;
    private Path mClipPath;
    private boolean misLeft = true;//tab选中位置
    private boolean isAnimation;//是否正在切换条目中
    private static final long DEFAULT_DURATION = 750;//动画的时间
    private List<String> mTitleList = new ArrayList<>();

    public SwitchBar(Context context) {
        super(context);
        init();
    }

    public SwitchBar(Context context, @Nullable AttributeSet attrs) {
        super(context, attrs);
        init();
    }

    public SwitchBar(Context context, @Nullable AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        init();
    }

    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        drawOverlay(canvas);
        drawStroke(canvas);
        drawText(canvas);
    }

    @Override
    protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
        super.onMeasure(widthMeasureSpec, heightMeasureSpec);
        int width = MeasureSpec.getSize(widthMeasureSpec);
        int height = width / 3;
        mTotalHeight = height - 10;
        mTotalleft = 5;
        mTotalTop = 5;
        mTotalRight = width - 5;
        mTotalBottom = height - 5;

        mOverlayRadius = (mTotalRight - mTotalleft) * 0.36F;
        if (mRectF == null) mRectF = new RectF(mTotalleft, mTotalTop, mTotalRight, mTotalBottom);
        if (mClipPath == null) {
            mClipPath = new Path();
            mClipPath.addRoundRect(mRectF, 1000, 1000, Path.Direction.CW);
            mCurrentPosition[0] = mTotalleft + mTotalHeight / 2 + 30;
            mCurrentPosition[1] = mTotalBottom;
        }
        Paint.FontMetrics fontMetrics = mTextPaint.getFontMetrics();
        float top = fontMetrics.top;//为基线到字体上边框的距离,即上图中的top
        float bottom = fontMetrics.bottom;//为基线到字体下边框的距离,即上图中的bottom
        mBaseLineY = (int) (height - top - bottom) / 2;
        setMeasuredDimension(width, height);
    }

    private void init() {
        mTitleList.add("1");
        mTitleList.add("2");

        mPaint = new Paint();
        mPaint.setStrokeWidth(10);
        mPaint.setColor(Color.RED);
        mPaint.setStyle(Paint.Style.STROKE);
        mPaint.setStrokeCap(Paint.Cap.SQUARE);
        mPaint.setAntiAlias(true);

        mTextPaint = new TextPaint();
        mTextPaint.setColor(Color.WHITE);
        mTextPaint.setTextSize(48);
        mTextPaint.setTypeface(Typeface.SERIF);
        mTextPaint.setFakeBoldText(true);
        mTextPaint.setAntiAlias(true);
        mTextPaint.setTextAlign(Paint.Align.CENTER);
    }

    private void drawStroke(Canvas canvas) {
        mPaint.setStrokeWidth(10);
        mPaint.setColor(Color.WHITE);
        canvas.drawRoundRect(mRectF, 1000, 1000, mPaint);
    }

    private void drawText(Canvas canvas) {
        for (int i = 0; i < mTitleList.size(); i++) {
            canvas.drawText(mTitleList.get(i), (getWidth() / mTitleList.size() / 2) * (2 * i + 1), mBaseLineY, mTextPaint);
        }
//        canvas.drawText("1", getWidth() / 4, mBaseLineY, mTextPaint);
//        canvas.drawText("2", getWidth() / 4 * 3, mBaseLineY, mTextPaint);
    }

    private void drawOverlay(Canvas canvas) {
        Paint mPaint = new Paint();
        mPaint.setColor(mCurrentPosition[0] > getWidth() / 2 ? colorPurple : colorRed);
        mPaint.setStyle(Paint.Style.FILL_AND_STROKE);
        mPaint.setStrokeWidth(1);
        canvas.save();
        canvas.clipPath(mClipPath);
        canvas.drawCircle(mCurrentPosition[0], mCurrentPosition[1], mOverlayRadius, mPaint);
        canvas.restore();
    }

    @Override
    public boolean onTouchEvent(MotionEvent event) {
        if (event.getAction() == MotionEvent.ACTION_DOWN) {
            if (event.getX() > getWidth() / 2) {
                switchB(false, DEFAULT_DURATION);
                Toast.makeText(MyApplication.getInstance().getApplicationContext(), "2", Toast.LENGTH_SHORT).show();
            } else {
                switchB(true, DEFAULT_DURATION);
                Toast.makeText(MyApplication.getInstance().getApplicationContext(), "1", Toast.LENGTH_SHORT).show();
            }
        }
        return super.onTouchEvent(event);
    }

    private void switchB(boolean isLeft, long duration) {
        if (misLeft == isLeft || isAnimation) return;
        Path overlayPath = new Path();
        RectF rectF = new RectF(mTotalleft + mTotalHeight / 2 + 30, mTotalBottom - mOverlayRadius, mTotalRight - mTotalHeight / 2 - 30, mTotalBottom + mOverlayRadius);
        if (isLeft) overlayPath.addArc(rectF, 0, 180);//右到左
        else overlayPath.addArc(rectF, 180, -180);//左到右
        PathMeasure pathMeasure = new PathMeasure(overlayPath, false);
        startPathAnim(pathMeasure, duration);
    }

    private void startPathAnim(final PathMeasure pathMeasure, long duration) {
        // 0 － getLength()
        ValueAnimator valueAnimator = ValueAnimator.ofFloat(0, pathMeasure.getLength());
        valueAnimator.setDuration(duration);
        // 减速插值器
        valueAnimator.setInterpolator(new DecelerateInterpolator());
        valueAnimator.addUpdateListener(new ValueAnimator.AnimatorUpdateListener() {

            @Override
            public void onAnimationUpdate(ValueAnimator animation) {
                float value = (Float) animation.getAnimatedValue();
                // 获取当前点坐标封装到mCurrentPosition
                pathMeasure.getPosTan(value, mCurrentPosition, null);
                postInvalidate();
            }
        });
        valueAnimator.addListener(new Animator.AnimatorListener() {
            @Override
            public void onAnimationStart(Animator animation) {
                isAnimation = true;
            }

            @Override
            public void onAnimationEnd(Animator animation) {
                misLeft = !misLeft;
                isAnimation = false;
            }

            @Override
            public void onAnimationCancel(Animator animation) {
                isAnimation = false;
            }

            @Override
            public void onAnimationRepeat(Animator animation) {

            }
        });
        valueAnimator.start();
    }


}
