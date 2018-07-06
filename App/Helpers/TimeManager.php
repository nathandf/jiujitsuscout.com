<?php

namespace Helpers;

class TimeManager
{

    public $now;
    public $today_begin;
    public $today_end;
    public $tomorrow_begin;
    public $tomorrow_end;

    public function __construct()
    {
        $this->now = time();
        $this->today_begin = strtotime( date( "Y-m-d", $this->now ) );

        $this->today_end = $this->today_begin + ( 60 * 60 * 24 );
        $this->now_datetime = date( "Y-m-d H:i:s", $this->now );

        $dateTime = new \DateTime( "tomorrow" );
        $this->tomorrow_datetime = $dateTime->format( "Y-m-d H:i:s" );

        $this->tomorrow_begin = strtotime( $this->tomorrow_datetime );
        $this->tomorrow_end = $this->tomorrow_begin + ( 60 * 60 * 24 );

        $this->next_monday = strtotime( "next monday" );
        $this->end_next_week = $this->next_monday + ( 60 * 60 * 24 * 7 );
    }

    public function isTomorrow( $timestamp )
    {
        if ( $timestamp >= $this->tomorrow_begin && $timestamp < $this->tomorrow_end ) {
            return true;
        }

        return false;
    }

    public function isToday( $timestamp )
    {
        if ( $timestamp >= $this->today_begin && $timestamp < $this->today_end ) {
            return true;
        }

        return false;
    }

    public function isPast( $timestamp )
    {
        if ( $timestamp < $this->today_begin ) {
            return true;
        }

        return false;
    }

    public function isThisWeek( $timestamp )
    {
        if ( $timestamp >= $this->tomorrow_end && $timestamp < $this->next_monday ) {
            return true;
        }

        return false;
    }

    public function isNextWeek( $timestamp )
    {
        if ( $timestamp >= $this->next_monday && $timestamp < $this->end_next_week ) {
            return true;
        }

        return false;
    }

    public function isFuture( $timestamp )
    {
        if ( $timestamp > $this->today_end ) {
            return true;
        }

        return false;
    }

}
