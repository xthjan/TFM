import { Body, Controller, Post } from '@nestjs/common';
import { Public } from 'src/auth/auth.jwt.guard';
import { AuthService } from 'src/services/auth.service';
@Public()
@Controller('auth')
export class AuthorizationController {
  constructor(private authService: AuthService) {}
  @Post('login')
  async login(@Body() req) {
    return this.authService.validateUser(req.username, req.password);
  }
}
