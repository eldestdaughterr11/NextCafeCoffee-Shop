import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function GET(req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const orderId = parseInt(params.id);
    if (isNaN(orderId)) return NextResponse.json({ error: 'Invalid ID' }, { status: 400 });

    const order = await prisma.order.findUnique({
      where: { id: orderId },
      include: {
        items: {
          include: {
            product: true
          }
        }
      }
    });

    if (!order) return NextResponse.json({ error: 'Order not found' }, { status: 404 });

    return NextResponse.json({ order }, { status: 200 });
  } catch (error) {
    console.error('Fetch Order Error:', error);
    return NextResponse.json({ error: 'Server Error' }, { status: 500 });
  }
}

export async function PUT(req: NextRequest, { params }: { params: { id: string } }) {
  try {
    const orderId = parseInt(params.id);
    if (isNaN(orderId)) return NextResponse.json({ error: 'Invalid ID' }, { status: 400 });

    const body = await req.json();
    if (!body.status) return NextResponse.json({ error: 'Status is required' }, { status: 400 });

    const updatedOrder = await prisma.order.update({
      where: { id: orderId },
      data: { status: body.status }
    });

    return NextResponse.json(updatedOrder, { status: 200 });
  } catch (error) {
    console.error('Update Order Error:', error);
    return NextResponse.json({ error: 'Failed to update order' }, { status: 500 });
  }
}
