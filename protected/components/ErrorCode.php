<?php
class ErrorCode
{
	const NONE = 0;

	// 0~99 system error

	// 100~199 user identity error
	const USER_NOT_EXIST = 100;
	const PASSWORD_INVALID = 101;
}