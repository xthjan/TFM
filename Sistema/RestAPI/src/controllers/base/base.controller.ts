import { Body, Get, Param, Post } from '@nestjs/common';
import { GenericService } from 'src/services/generic/generic.service';
import { Document } from 'mongoose';

export abstract class BaseController<
  TSchema extends Document,
  TService extends GenericService<TSchema>
> {
  constructor(private readonly service: TService) {}
  @Get()
  async getAll(): Promise<TSchema[]> {
    return this.service.getall();
  }
  @Get(':id')
  async get(@Param('id') id: string): Promise<TSchema> {
    return this.service.findOne({ _id: id });
  }
  @Post()
  async post(@Body() usuario: TSchema): Promise<TSchema> {
    return this.service.CreateRecord(usuario);
  }
}
